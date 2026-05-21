<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BeritaController extends Controller
{
    private function format(Berita $b, bool $withContent = false): array
    {
        $out = [
            'slug' => $b->slug,
            'title' => $b->title,
            'excerpt' => $b->excerpt,
            'cover_image' => $b->cover_image ? '/storage/' . $b->cover_image : null,
            'date' => $b->published_at->format('d.m.Y'),
            'date_full' => $b->published_at->locale('id')->translatedFormat('d F Y'),
            'date_iso' => $b->published_at->toDateString(),
            'reading_time' => "{$b->reading_time_minutes} menit",
            'categories' => $b->kategoris->pluck('name'),
            'is_featured' => $b->is_featured,
            'author' => $b->creator ? ['name' => $b->creator->name] : null,
        ];

        if ($withContent) {
            $out['content'] = $b->content;
        }

        return $out;
    }

    public function index(Request $request): Response
    {
        $kategori = $request->query('kategori', 'all');
        $perPage = 12;

        $query = Berita::published()
            ->with(['kategoris', 'creator'])
            ->latest('published_at');

        if ($kategori !== 'all') {
            $query->whereHas('kategoris', fn ($q) => $q->where('name', $kategori));
        }

        $totalCount = Berita::published()->count();

        $featured = $kategori === 'all'
            ? Berita::published()->with(['kategoris', 'creator'])->where('is_featured', true)->first()
                ?? Berita::published()->with(['kategoris', 'creator'])->latest('published_at')->first()
            : null;

        $paginated = $query
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->paginate($perPage)
            ->withQueryString();

        $paginated->getCollection()->transform(fn (Berita $b) => $this->format($b));

        $kategoris = Kategori::withCount(['beritas' => fn ($q) => $q->where('is_published', true)])
            ->get(['id', 'name'])
            ->map(fn (Kategori $k) => ['name' => $k->name, 'count' => $k->beritas_count]);

        return Inertia::render('Berita/Index', [
            'featured' => $featured ? $this->format($featured) : null,
            'berita' => $paginated,
            'kategoris' => $kategoris,
            'currentKategori' => $kategori,
            'totalCount' => $totalCount,
        ]);
    }

    public function show(string $slug): Response
    {
        $berita = Berita::published()
            ->with(['kategoris', 'creator'])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Berita::published()
            ->with(['kategoris', 'creator'])
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Berita $b) => $this->format($b));

        return Inertia::render('Berita/Show', [
            'berita' => $this->format($berita, withContent: true),
            'related' => $related,
        ]);
    }
}
