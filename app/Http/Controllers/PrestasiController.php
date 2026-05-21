<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Inertia\Inertia;
use Inertia\Response;

class PrestasiController extends Controller
{
    private const PRESTASI_MAP = [
        'sekolah' => [
            'slug'        => 'prestasi-sekolah',
            'name'        => 'Prestasi Sekolah',
            'description' => 'Penghargaan, akreditasi, dan pencapaian institusi SMK Negeri 2 Cimahi di tingkat regional maupun nasional.',
        ],
        'guru' => [
            'slug'        => 'prestasi-guru',
            'name'        => 'Prestasi Guru',
            'description' => 'Pencapaian, penghargaan, dan karya unggulan dari tenaga pendidik SMK Negeri 2 Cimahi.',
        ],
        'siswa' => [
            'slug'        => 'prestasi-siswa',
            'name'        => 'Prestasi Siswa',
            'description' => 'Kejuaraan, lomba, dan penghargaan yang diraih oleh siswa-siswi SMK Negeri 2 Cimahi.',
        ],
    ];

    public function show(string $type): Response
    {
        abort_unless(isset(self::PRESTASI_MAP[$type]), 404);

        $meta     = self::PRESTASI_MAP[$type];
        $kategori = Kategori::where('slug', $meta['slug'])->firstOrFail();

        $query = Berita::published()
            ->with('kategoris')
            ->whereHas('kategoris', fn ($q) => $q->where('kategoris.id', $kategori->id))
            ->latest('published_at');

        $totalCount = (clone $query)->count();

        $featured = (clone $query)->where('is_featured', true)->first()
            ?? (clone $query)->first();

        $paginated = $query
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->paginate(9)
            ->withQueryString();

        $paginated->getCollection()->transform(fn (Berita $b) => $this->formatBerita($b));

        return Inertia::render('Prestasi/Show', [
            'prestasi'   => $meta,
            'featured'   => $featured ? $this->formatBerita($featured) : null,
            'berita'     => $paginated,
            'totalCount' => $totalCount,
        ]);
    }

    private function formatBerita(Berita $b): array
    {
        return [
            'slug'         => $b->slug,
            'title'        => $b->title,
            'excerpt'      => $b->excerpt,
            'date'         => $b->published_at->format('d.m.Y'),
            'date_full'    => $b->published_at->locale('id')->translatedFormat('d F Y'),
            'reading_time' => "{$b->reading_time_minutes} menit",
            'categories'   => $b->kategoris->pluck('name'),
            'is_featured'  => $b->is_featured,
        ];
    }
}
