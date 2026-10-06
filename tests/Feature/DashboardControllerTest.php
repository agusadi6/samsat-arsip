<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_the_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'nip' => 'ADMIN-001',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'nip' => 'PEGAWAI-001',
            'role' => 'pegawai',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Jumlah pegawai: 1');
    }

    public function test_pegawai_can_view_their_dashboard(): void
    {
        $pegawai = User::factory()->create([
            'nip' => 'PEGAWAI-002',
            'role' => 'pegawai',
        ]);

        $this->actingAs($pegawai)
            ->get(route('pegawai.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Pegawai')
            ->assertSee($pegawai->name);
    }

    public function test_pegawai_is_redirected_from_the_admin_dashboard(): void
    {
        $pegawai = User::factory()->create([
            'nip' => 'PEGAWAI-003',
            'role' => 'pegawai',
        ]);

        $this->actingAs($pegawai)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('pegawai.dashboard'));
    }
}
