<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kompetensi;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml dynamic dari DB.
     * URL: /sitemap.xml
     */
    public function index(): Response
    {
        $urls = [];

        // Static pages — homepage + profil + kontak
        $staticPages = [
            ['/',                          'daily',   '1.0'],
            ['/profil/sekolah',            'monthly', '0.7'],
            ['/profil/sejarah',            'monthly', '0.6'],
            ['/profil/visi-misi',          'monthly', '0.6'],
            ['/profil/kepala-sekolah',     'monthly', '0.6'],
            ['/kontak',                    'monthly', '0.8'],
            ['/berita',                    'daily',   '0.9'],
            ['/kurikulum',                 'weekly',  '0.7'],
            ['/kesiswaan/program',         'weekly',  '0.7'],
            ['/kesiswaan/rekap-siswa',     'monthly', '0.5'],
            ['/hubungan-industri',         'weekly',  '0.7'],
            ['/hubungan-industri/bkk',     'weekly',  '0.7'],
            ['/prestasi/sekolah',          'weekly',  '0.7'],
            ['/prestasi/guru',             'weekly',  '0.7'],
            ['/prestasi/siswa',            'weekly',  '0.7'],
        ];

        foreach ($staticPages as [$loc, $freq, $priority]) {
            $urls[] = [
                'loc'        => url($loc),
                'changefreq' => $freq,
                'priority'   => $priority,
                'lastmod'    => null,
            ];
        }

        // Dynamic: berita yang sudah published
        Berita::published()
            ->select(['slug', 'updated_at', 'published_at'])
            ->get()
            ->each(function (Berita $b) use (&$urls) {
                $urls[] = [
                    'loc'        => url('/berita/'.$b->slug),
                    'changefreq' => 'monthly',
                    'priority'   => '0.7',
                    'lastmod'    => $b->updated_at?->toAtomString(),
                ];
            });

        // Dynamic: kompetensi aktif (slug langsung pakai route /kompetensi/{slug})
        Kompetensi::active()
            ->select(['slug', 'updated_at'])
            ->get()
            ->each(function (Kompetensi $k) use (&$urls) {
                $urls[] = [
                    'loc'        => url('/kompetensi/'.$k->slug),
                    'changefreq' => 'monthly',
                    'priority'   => '0.8',
                    'lastmod'    => $k->updated_at?->toAtomString(),
                ];
            });

        $xml = $this->generateXml($urls);

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600'); // cache 1 jam
    }

    private function generateXml(array $urls): string
    {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>".htmlspecialchars($url['loc'])."</loc>\n";
            if ($url['lastmod']) {
                $xml .= "    <lastmod>".$url['lastmod']."</lastmod>\n";
            }
            $xml .= "    <changefreq>".$url['changefreq']."</changefreq>\n";
            $xml .= "    <priority>".$url['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
