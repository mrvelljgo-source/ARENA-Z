<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. Registrasi user berhasil.
     */
    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/user/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@esports.sch.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'school_name' => 'SMK Negeri 1 Surabaya',
            'phone' => '081234567890',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'budi@esports.sch.id',
            'role' => 'user',
            'school_name' => 'SMK Negeri 1 Surabaya',
        ]);

        $user = User::where('email', 'budi@esports.sch.id')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * 2. Registrasi menggunakan email duplikat ditolak.
     */
    public function test_user_registration_rejects_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'existing@example.com',
            'role' => 'user',
        ]);

        $response = $this->from('/user/register')->post('/user/register', [
            'name' => 'User Duplikat',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/user/register');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * 3. Login user berhasil.
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'player@arenaz.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/user/login', [
            'email' => 'player@arenaz.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * 4. Login dengan password salah ditolak.
     */
    public function test_login_with_wrong_password_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'user@arenaz.com',
            'password' => Hash::make('correct_password'),
            'role' => 'user',
        ]);

        $response = $this->from('/user/login')->post('/user/login', [
            'email' => 'user@arenaz.com',
            'password' => 'wrong_password',
            'role' => 'user',
        ]);

        $response->assertRedirect('/user/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * 5. Login admin berhasil.
     */
    public function test_admin_can_login_successfully(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@arenaz.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@arenaz.com',
            'password' => 'admin12345',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * 6. User biasa gagal login sebagai admin.
     */
    public function test_regular_user_cannot_login_as_admin(): void
    {
        User::factory()->create([
            'email' => 'student@arenaz.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'student@arenaz.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * 7. User tidak dapat mengakses dashboard admin.
     */
    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertForbidden();
    }

    /**
     * 8. Admin tidak dapat mengakses dashboard user.
     */
    public function test_admin_cannot_access_user_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/user/dashboard');
        $response->assertForbidden();
    }

    /**
     * 9. Logout berhasil.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/user/login');
        $this->assertGuest();
    }

    /**
     * 10. Session tidak dapat digunakan kembali setelah logout.
     */
    public function test_session_cannot_be_reused_after_logout(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user);
        $this->assertAuthenticated();

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // Akses route privat user setelah logout diarahkan ke halaman login
        $response = $this->get('/user/dashboard');
        $response->assertRedirect(route('login'));
    }
}
