<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/informasi')->assertRedirect('/login');
    }

    public function test_user_registers_and_is_logged_in_immediately(): void
    {
        $response = $this->post('/register', [
            'username' => 'rina_17',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ]);

        $response->assertRedirect(route('informasi'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['username' => 'rina_17', 'role' => 'user']);
    }

    public function test_username_must_be_unique(): void
    {
        User::create(['username' => 'sari_18', 'password' => 'rahasia123', 'role' => 'user']);

        $this->from('/register')->post('/register', [
            'username' => 'sari_18',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertSessionHasErrors('username');
    }

    public function test_user_can_login_with_username(): void
    {
        $user = User::create(['username' => 'dina_19', 'password' => 'rahasia123', 'role' => 'user']);

        $this->post('/login', ['username' => 'dina_19', 'password' => 'rahasia123'])
            ->assertRedirect(route('informasi'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::create(['username' => 'wati_20', 'password' => 'rahasia123', 'role' => 'user']);

        $this->from('/login')->post('/login', ['username' => 'wati_20', 'password' => 'salah'])
            ->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_all_pages_render_for_a_logged_in_user(): void
    {
        $user = User::create(['username' => 'lia_21', 'password' => 'rahasia123', 'role' => 'admin']);

        foreach (['informasi', 'kuis', 'lila', 'layanan', 'menarik'] as $name) {
            $this->actingAs($user)->get(route($name))
                ->assertOk()
                ->assertSee('Layanan Infogizi');
        }
    }

    public function test_account_page_shows_profile_and_changes_password(): void
    {
        $user = User::create(['username' => 'mila_22', 'password' => 'lamasandi', 'role' => 'user']);

        $this->actingAs($user)->get(route('akun'))
            ->assertOk()
            ->assertSee('mila_22')
            ->assertSee('Ubah kata sandi');

        $this->actingAs($user)->put(route('akun.password'), ['password' => 'barusandi'])
            ->assertRedirect(route('akun'));

        $this->assertTrue(Hash::check('barusandi', $user->fresh()->password));
    }

    public function test_logout_ends_the_session(): void
    {
        $user = User::create(['username' => 'nina_23', 'password' => 'rahasia123', 'role' => 'user']);

        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
