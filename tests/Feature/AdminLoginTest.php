<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_a_separate_admin_login_link(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('admin.login'));
    }

    public function test_admin_can_log_in_from_the_admin_login_page(): void
    {
        $admin = User::factory()->create([
            'nip' => 'ADMIN-LOGIN-001',
            'email' => 'admin-login@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        $this->post(route('admin.login.submit'), [
            'email' => 'admin-login@example.com',
            'password' => 'password',
        ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_pegawai_cannot_log_in_from_the_admin_login_page(): void
    {
        User::factory()->create([
            'nip' => 'PEGAWAI-LOGIN-001',
            'email' => 'pegawai-login@example.com',
            'role' => 'pegawai',
            'password' => 'password',
        ]);

        $this->from(route('admin.login'))
            ->post(route('admin.login.submit'), [
                'email' => 'pegawai-login@example.com',
                'password' => 'password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
