<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Kompetensi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_dapat_diakses(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=utf-8');
    }

    public function test_sitemap_kembalikan_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent();

        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString('</urlset>', $content);
    }

    public function test_sitemap_include_homepage(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertSee(url('/'), false);
    }

    public function test_sitemap_include_berita_published(): void
    {
        $berita = Berita::factory()->create(['slug' => 'berita-test-sitemap']);

        $response = $this->get('/sitemap.xml');

        $response->assertSee(url('/berita/berita-test-sitemap'), false);
    }

    public function test_sitemap_tidak_include_berita_unpublished(): void
    {
        Berita::factory()->draft()->create(['slug' => 'draft-tidak-tampil']);

        $response = $this->get('/sitemap.xml');

        $response->assertDontSee('draft-tidak-tampil');
    }

    public function test_sitemap_include_kompetensi_active(): void
    {
        Kompetensi::factory()->create(['slug' => 'animasi-test', 'is_active' => true]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee(url('/kompetensi/animasi-test'), false);
    }

    public function test_sitemap_tidak_include_kompetensi_inactive(): void
    {
        Kompetensi::factory()->inactive()->create(['slug' => 'kompetensi-nonaktif']);

        $response = $this->get('/sitemap.xml');

        $response->assertDontSee('kompetensi-nonaktif');
    }
}
