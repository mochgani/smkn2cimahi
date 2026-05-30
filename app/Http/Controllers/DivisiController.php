<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Divisi;
use Inertia\Inertia;
use Inertia\Response;

class DivisiController extends Controller
{
    public function show(string $slug): Response
    {
        $divisi = Divisi::where('slug', $slug)->firstOrFail();

        $query = Berita::published()
            ->with('kategoris')
            ->where('divisi_id', $divisi->id)
            ->latest('published_at');

        $totalCount = (clone $query)->count();

        $featured = (clone $query)->where('is_featured', true)->first()
            ?? (clone $query)->first();

        $paginated = $query
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->paginate(9)
            ->withQueryString();

        $paginated->getCollection()->transform(fn (Berita $b) => $this->formatBerita($b));

        return Inertia::render('Divisi/Show', [
            'divisi' => [
                'slug'        => $divisi->slug,
                'name'        => $divisi->name,
                'description' => $divisi->description,
            ],
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
            'cover_image'  => $b->cover_image ? '/storage/'.$b->cover_image : null,
            'date'         => $b->published_at->format('d.m.Y'),
            'date_full'    => $b->published_at->locale('id')->translatedFormat('d F Y'),
            'reading_time' => "{$b->reading_time_minutes} menit",
            'categories'   => $b->kategoris->pluck('name'),
            'is_featured'  => $b->is_featured,
        ];
    }
}
