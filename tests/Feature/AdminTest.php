<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
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

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([ChecklistItemSeeder::class, QuizSeeder::class]);
    }

    private function admin(): User
    {
        return User::create(['username' => 'admin', 'password' => 'admin123', 'role' => 'admin']);
    }

    private function regular(): User
    {
        return User::create(['username' => 'rina_17', 'password' => 'rahasia123', 'role' => 'user']);
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect('/login');
    }

    public function test_regular_user_is_forbidden(): void
    {
        $this->actingAs($this->regular())->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_open_dashboard_and_modules(): void
    {
        $admin = $this->admin();

        foreach ([
            'admin.dashboard',
            'admin.users.index',
            'admin.users.create',
            'admin.quiz.index',
            'admin.quiz.create',
            'admin.target.index',
            'admin.target.create',
            'admin.data.lila',
            'admin.data.quiz',
            'admin.data.activity',
            'admin.data.target',
            'admin.export.index',
            'admin.lainnya',
        ] as $name) {
            $this->actingAs($admin)->get(route($name))->assertOk();
        }
    }

    public function test_admin_can_create_update_and_delete_a_user(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'username' => 'baru_01',
            'password' => 'rahasia123',
            'role' => 'user',
            'bidan_phone' => '0812000111',
        ])->assertRedirect(route('admin.users.index'));

        $user = User::where('username', 'baru_01')->firstOrFail();
        $this->assertSame('user', $user->role);

        $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'username' => 'baru_01',
            'role' => 'admin',
            'bidan_phone' => '0812000222',
        ])->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertSame('admin', $user->role);
        $this->assertSame('0812000222', $user->bidan_phone);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $user))->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_or_demote_self(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))->assertSessionHasErrors('user');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);

        $this->actingAs($admin)->put(route('admin.users.update', $admin), [
            'username' => 'admin',
            'role' => 'user',
        ])->assertSessionHasErrors('role');
        $this->assertSame('admin', $admin->fresh()->role);
    }

    public function test_admin_can_manage_checklist_targets(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.target.store'), ['label' => 'Minum air 8 gelas', 'position' => 9])
            ->assertRedirect(route('admin.target.index'));
        $this->assertDatabaseHas('checklist_items', ['label' => 'Minum air 8 gelas']);

        $item = ChecklistItem::where('label', 'Minum air 8 gelas')->firstOrFail();
        $this->actingAs($admin)->put(route('admin.target.update', $item), ['label' => 'Minum air 8 gelas sehari', 'position' => 9])
            ->assertRedirect(route('admin.target.index'));
        $this->assertSame('Minum air 8 gelas sehari', $item->fresh()->label);

        $this->actingAs($admin)->delete(route('admin.target.destroy', $item))->assertRedirect(route('admin.target.index'));
        $this->assertDatabaseMissing('checklist_items', ['id' => $item->id]);
    }

    public function test_admin_can_create_knowledge_question_with_options(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.quiz.store'), [
            'type' => 'pengetahuan',
            'indicator' => 'Uji',
            'text' => 'Berapa batas LILA?',
            'position' => 20,
            'explanation' => 'Batasnya 23,5 cm.',
            'options' => ['20 cm', '23,5 cm', '30 cm'],
            'correct' => 1,
        ])->assertRedirect(route('admin.quiz.index'));

        $question = QuizQuestion::where('text', 'Berapa batas LILA?')->firstOrFail();
        $this->assertSame(3, $question->options()->count());
        $this->assertSame(1, QuizOption::where('quiz_question_id', $question->id)->where('is_correct', true)->value('position'));
    }

    public function test_admin_can_create_attitude_question_with_auto_scale(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.quiz.store'), [
            'type' => 'sikap',
            'text' => 'Saya rajin mengukur LILA.',
            'position' => 20,
            'aspect' => 'Konatif',
            'is_favorable' => 1,
            'good_feedback' => 'Bagus',
            'bad_feedback' => 'Ayo tingkatkan',
        ])->assertRedirect(route('admin.quiz.index'));

        $question = QuizQuestion::where('text', 'Saya rajin mengukur LILA.')->firstOrFail();
        $this->assertSame(4, $question->options()->count());
        $this->assertTrue($question->is_favorable);
    }

    public function test_admin_can_delete_a_question(): void
    {
        $admin = $this->admin();
        $question = QuizQuestion::where('type', 'pengetahuan')->firstOrFail();

        $this->actingAs($admin)->delete(route('admin.quiz.destroy', $question))->assertRedirect(route('admin.quiz.index'));
        $this->assertDatabaseMissing('quiz_questions', ['id' => $question->id]);
        $this->assertDatabaseMissing('quiz_options', ['quiz_question_id' => $question->id]);
    }

    public function test_user_detail_shows_target_and_history_logs(): void
    {
        $admin = $this->admin();
        $user = $this->regular();
        $item = ChecklistItem::orderBy('position')->firstOrFail();

        DailyTargetLog::create(['user_id' => $user->id, 'log_date' => now()->toDateString(), 'checklist_item_id' => $item->id, 'is_done' => true]);
        LilaMeasurement::create(['user_id' => $user->id, 'value_cm' => 22.0, 'measured_at' => now()->toDateString()]);
        QuizAttempt::create(['user_id' => $user->id, 'type' => 'pengetahuan', 'raw_score' => 13, 'max_score' => 13, 'percentage' => 100, 'taken_at' => now()->toDateString()]);
        ActivityLog::create(['user_id' => $user->id, 'event' => 'kunjungan', 'description' => 'Membuka Informasi']);

        $this->actingAs($admin)->get(route('admin.users.show', $user))
            ->assertOk()
            ->assertSee('Target harian')
            ->assertSee($item->label)
            ->assertSee('Log aktivitas')
            ->assertSee('Riwayat LILA')
            ->assertSee('Riwayat kuis')
            ->assertSee('22,0 cm')
            ->assertSee('100%');
    }

    public function test_admin_can_export_csv(): void
    {
        $admin = $this->admin();
        User::create(['username' => 'sari_18', 'password' => 'rahasia123', 'role' => 'user']);

        $response = $this->actingAs($admin)->get(route('admin.export.download', 'users'));

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('sari_18', $response->streamedContent());
    }
}
