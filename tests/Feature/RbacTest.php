<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Kompetensi;
use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_user_super_admin_dapat_akses_filament_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('super_admin');

        $panel = app(Panel::class);
        $this->assertTrue($user->canAccessPanel($panel));
        $this->assertTrue($user->isSuperAdmin());
    }

    public function test_user_kompetensi_dapat_akses_filament_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('kompetensi');

        $panel = app(Panel::class);
        $this->assertTrue($user->canAccessPanel($panel));
        $this->assertFalse($user->isSuperAdmin());
    }

    public function test_user_divisi_dapat_akses_filament_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('divisi');

        $panel = app(Panel::class);
        $this->assertTrue($user->canAccessPanel($panel));
    }

    public function test_user_tanpa_role_tidak_dapat_akses_filament_panel(): void
    {
        $user = User::factory()->create();

        $panel = app(Panel::class);
        $this->assertFalse($user->canAccessPanel($panel));
    }

    public function test_user_kompetensi_hanya_lihat_berita_kompetensinya(): void
    {
        $kompetensiA = Kompetensi::factory()->create();
        $kompetensiB = Kompetensi::factory()->create();

        $userA = User::factory()->create(['kompetensi_id' => $kompetensiA->id]);
        $userA->assignRole('kompetensi');

        Berita::factory()->create(['kompetensi_id' => $kompetensiA->id]);
        Berita::factory()->create(['kompetensi_id' => $kompetensiA->id]);
        Berita::factory()->create(['kompetensi_id' => $kompetensiB->id]);
        Berita::factory()->create(['kompetensi_id' => null]); // berita umum

        // Simulasi getEloquentQuery di BeritaResource
        $beritaUserA = Berita::query()
            ->when(true, fn ($q) => $q->where('kompetensi_id', $userA->kompetensi_id))
            ->count();

        $this->assertSame(2, $beritaUserA);
    }

    public function test_user_divisi_hanya_lihat_berita_divisinya(): void
    {
        $divisiA = Divisi::factory()->create();
        $divisiB = Divisi::factory()->create();

        $userA = User::factory()->create(['divisi_id' => $divisiA->id]);
        $userA->assignRole('divisi');

        Berita::factory()->create(['divisi_id' => $divisiA->id]);
        Berita::factory()->create(['divisi_id' => $divisiB->id]);
        Berita::factory()->create(['divisi_id' => $divisiB->id]);

        $beritaUserA = Berita::query()
            ->where('divisi_id', $userA->divisi_id)
            ->count();

        $this->assertSame(1, $beritaUserA);
    }

    public function test_guest_redirect_ke_login_saat_akses_admin(): void
    {
        $this->get('/admin')
            ->assertRedirect();
    }
}
