<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Kompetensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_berita_pending_belum_terlihat_di_frontend(): void
    {
        $berita = Berita::factory()->pending()->create([
            'is_published' => true, // bahkan jika published tetap dihide
        ]);

        $this->assertFalse(
            Berita::published()->where('id', $berita->id)->exists(),
            'Berita pending masih muncul di scope published'
        );
    }

    public function test_berita_approved_tampil_di_frontend(): void
    {
        $berita = Berita::factory()->create([
            'is_published'    => true,
            'approval_status' => 'approved',
        ]);

        $this->assertTrue(
            Berita::published()->where('id', $berita->id)->exists()
        );
    }

    public function test_berita_rejected_tidak_tampil_di_frontend(): void
    {
        $berita = Berita::factory()->rejected()->create([
            'is_published' => true,
        ]);

        $this->assertFalse(
            Berita::published()->where('id', $berita->id)->exists()
        );
    }

    public function test_state_transition_pending_ke_approved(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');

        $berita = Berita::factory()->pending()->create();

        // Simulasi action Approve dari tabel admin
        $berita->update([
            'approval_status' => 'approved',
            'is_published'    => true,
            'approved_by'     => $admin->id,
            'approved_at'     => now(),
        ]);

        $berita->refresh();
        $this->assertSame('approved', $berita->approval_status);
        $this->assertTrue($berita->is_published);
        $this->assertSame($admin->id, $berita->approved_by);
        $this->assertNotNull($berita->approved_at);
    }

    public function test_state_transition_pending_ke_rejected(): void
    {
        $berita = Berita::factory()->pending()->create();

        $berita->update([
            'approval_status' => 'rejected',
            'is_published'    => false,
        ]);

        $berita->refresh();
        $this->assertSame('rejected', $berita->approval_status);
        $this->assertFalse($berita->is_published);
    }
}
