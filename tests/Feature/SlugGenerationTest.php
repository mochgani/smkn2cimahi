<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_berita_slug_otomatis_dari_title_jika_kosong(): void
    {
        $berita = Berita::create([
            'title'        => 'Pengumuman Penerimaan Murid Baru 2026',
            'excerpt'      => 'Test excerpt yang cukup panjang.',
            'content'      => '<p>Test content.</p>',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertSame('pengumuman-penerimaan-murid-baru-2026', $berita->slug);
    }

    public function test_berita_slug_explicit_tidak_di_override(): void
    {
        $berita = Berita::create([
            'slug'         => 'custom-slug-saya',
            'title'        => 'Judul Yang Beda',
            'excerpt'      => 'Test.',
            'content'      => '<p>Test.</p>',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertSame('custom-slug-saya', $berita->slug);
    }

    public function test_kategori_slug_otomatis_dari_name_jika_kosong(): void
    {
        $kategori = Kategori::create([
            'name'  => 'Prestasi Sekolah',
            'color' => '#ff0000',
        ]);

        $this->assertSame('prestasi-sekolah', $kategori->slug);
    }

    public function test_kategori_slug_explicit_tidak_di_override(): void
    {
        $kategori = Kategori::create([
            'name'  => 'Berita Umum',
            'slug'  => 'umum',
            'color' => '#0d6e3f',
        ]);

        $this->assertSame('umum', $kategori->slug);
    }
}
