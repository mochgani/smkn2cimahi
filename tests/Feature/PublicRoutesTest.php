<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Kompetensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_berita_index_loads(): void
    {
        Berita::factory(3)->create();

        $this->get('/berita')->assertOk();
    }

    public function test_berita_show_loads(): void
    {
        $berita = Berita::factory()->create();

        $this->get("/berita/{$berita->slug}")
            ->assertOk();
    }

    public function test_kompetensi_animasi_loads(): void
    {
        Kompetensi::factory()->create(['slug' => 'animasi', 'name' => 'Animasi']);

        $this->get('/kompetensi/animasi')->assertOk();
    }

    public function test_kompetensi_rpl_loads(): void
    {
        Kompetensi::factory()->create(['slug' => 'rpl', 'name' => 'RPL']);

        $this->get('/kompetensi/rpl')->assertOk();
    }

    public function test_kontak_page_loads(): void
    {
        $this->get('/kontak')->assertOk();
    }

    public function test_profil_visi_misi_loads(): void
    {
        $this->get('/profil/visi-misi')->assertOk();
    }

    public function test_profil_sejarah_loads(): void
    {
        $this->get('/profil/sejarah')->assertOk();
    }

    public function test_profil_kepala_sekolah_loads(): void
    {
        $this->get('/profil/kepala-sekolah')->assertOk();
    }

    public function test_berita_non_existent_returns_404(): void
    {
        $this->get('/berita/slug-tidak-ada')->assertNotFound();
    }
}
