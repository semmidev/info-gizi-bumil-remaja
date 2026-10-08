<?php

namespace Tests\Feature;

use App\Models\ChecklistItem;
use App\Models\DailyTargetLog;
use App\Models\LilaMeasurement;
use App\Models\QuizAttempt;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\User;
use Database\Seeders\ChecklistItemSeeder;
use Database\Seeders\QuizSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataPersistenceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([ChecklistItemSeeder::class, QuizSeeder::class]);
    }

    private function user(): User
    {
        return User::create(['username' => 'sari_18', 'password' => 'rahasia123', 'role' => 'user']);
    }

    public function test_master_data_is_seeded_exactly_as_the_ui(): void
    {
        $this->assertSame(5, ChecklistItem::count());
        $this->assertSame(25, QuizQuestion::count());
        $this->assertSame(13, QuizQuestion::where('type', 'pengetahuan')->count());
        $this->assertSame(6, QuizQuestion::where('type', 'sikap')->count());
        $this->assertSame(6, QuizQuestion::where('type', 'tindakan')->count());
        $this->assertSame(87, QuizOption::count());

        $first = QuizQuestion::where('type', 'pengetahuan')->orderBy('position')->first();
        $this->assertSame('Pengertian KEK', $first->indicator);
        $this->assertSame(3, $first->options()->count());
        $this->assertSame(1, $first->options()->where('is_correct', true)->value('position'));
    }

    public function test_informasi_page_injects_the_daily_targets(): void
    {
        $this->actingAs($this->user())->get(route('informasi'))
            ->assertOk()
            ->assertSee('window.__DATA', false)
            ->assertSee('Minum tablet tambah darah');
    }

    public function test_target_toggle_is_persisted(): void
    {
        $user = $this->user();
        $item = ChecklistItem::orderBy('position')->first();

        $this->actingAs($user)->putJson(route('api.target.update'), [
            'checklist_item_id' => $item->id,
            'is_done' => true,
        ])->assertOk()->assertJson(['is_done' => true]);

        $this->assertDatabaseHas('daily_target_logs', [
            'user_id' => $user->id,
            'checklist_item_id' => $item->id,
            'is_done' => true,
        ]);
    }

    public function test_quiz_attempt_computes_max_and_percentage(): void
    {
        $user = $this->user();
        $q1 = QuizQuestion::where('type', 'pengetahuan')->orderBy('position')->firstOrFail();
        $q2 = QuizQuestion::where('type', 'pengetahuan')->orderBy('position')->skip(1)->firstOrFail();

        $this->actingAs($user)->postJson(route('api.quiz-attempt.store'), [
            'type' => 'pengetahuan',
            'raw_score' => 13,
            'answers' => [
                ['question_id' => $q1->id, 'option_position' => 1],
                ['question_id' => $q2->id, 'option_position' => 0],
            ],
        ])->assertOk()->assertJson(['max_score' => 13, 'percentage' => 100]);

        $this->assertDatabaseHas('quiz_answers', ['quiz_question_id' => $q1->id, 'is_correct' => true]);
        $this->assertDatabaseHas('quiz_answers', ['quiz_question_id' => $q2->id, 'is_correct' => false]);

        $this->actingAs($user)->postJson(route('api.quiz-attempt.store'), [
            'type' => 'sikap',
            'raw_score' => 12,
        ])->assertOk()->assertJson(['max_score' => 24, 'percentage' => 50]);

        $this->assertDatabaseCount('quiz_attempts', 2);

        $this->actingAs($user)->get(route('kuis'))
            ->assertOk()
            ->assertSee('Riwayat kuis')
            ->assertSee($q1->text)
            ->assertSee('Jawabanmu');
    }

    public function test_target_quiz_and_lila_histories_are_paginated(): void
    {
        $user = $this->user();
        $item = ChecklistItem::orderBy('position')->firstOrFail();

        for ($i = 1; $i <= 9; $i++) {
            DailyTargetLog::create([
                'user_id' => $user->id,
                'log_date' => now()->subDays($i)->toDateString(),
                'checklist_item_id' => $item->id,
                'is_done' => true,
            ]);
        }

        $this->actingAs($user)->get(route('informasi'))
            ->assertOk()
            ->assertSee('Riwayat target')
            ->assertSee('Hal 1 / 2');

        for ($i = 1; $i <= 11; $i++) {
            LilaMeasurement::create([
                'user_id' => $user->id,
                'value_cm' => 22 + $i / 10,
                'measured_at' => now()->subDays($i)->toDateString(),
            ]);
        }

        $this->actingAs($user)->get(route('lila'))
            ->assertOk()
            ->assertSee('Hal 1 / 2');

        for ($i = 0; $i < 6; $i++) {
            QuizAttempt::create([
                'user_id' => $user->id,
                'type' => 'pengetahuan',
                'raw_score' => 1,
                'max_score' => 13,
                'percentage' => 8,
                'taken_at' => now()->subDays($i)->toDateString(),
            ]);
        }

        $this->actingAs($user)->get(route('kuis'))
            ->assertOk()
            ->assertSee('Hal 1 / 2');
    }

    public function test_lila_measurements_are_saved_and_cleared(): void
    {
        $user = $this->user();

        $this->actingAs($user)->postJson(route('api.lila.store'), ['value_cm' => 22.5])
            ->assertOk()->assertJson(['value' => 22.5]);

        $this->assertDatabaseHas('lila_measurements', ['user_id' => $user->id, 'value_cm' => 22.5]);

        $this->actingAs($user)->deleteJson(route('api.lila.destroy'))->assertOk();
        $this->assertDatabaseCount('lila_measurements', 0);
    }

    public function test_bidan_phone_is_saved_on_user(): void
    {
        $user = $this->user();

        $this->actingAs($user)->putJson(route('api.bidan.update'), ['bidan_phone' => '081234567890'])
            ->assertOk()->assertJson(['bidan_phone' => '081234567890']);

        $this->assertSame('081234567890', $user->fresh()->bidan_phone);
    }

    public function test_activity_events_can_be_stored_and_listed(): void
    {
        $user = $this->user();

        $this->actingAs($user)->postJson(route('api.activity.store'), [
            'device_id' => 'HP-TEST01',
            'events' => [
                ['event' => 'kunjungan', 'description' => 'Membuka Informasi'],
                ['event' => 'baca_menu', 'description' => 'Informasi', 'duration_seconds' => 120],
            ],
        ])->assertOk()->assertJson(['stored' => 2]);

        $this->assertDatabaseCount('activity_logs', 2);

        $this->actingAs($user)->getJson(route('api.activity.index'))
            ->assertOk()
            ->assertJsonPath('summary.kunjungan', 1)
            ->assertJsonPath('summary.minutes', 2);
    }
}
