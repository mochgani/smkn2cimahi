<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\HeroBanner;
use App\Models\Kompetensi;
use App\Models\RekapSiswa;
use App\Models\SchoolStat;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $bannerSlides = HeroBanner::active()->get()->map(fn (HeroBanner $b) => [
            'tag'      => $b->tag,
            'date'     => $b->date_display,
            'title'    => $b->title,
            'desc'     => $b->desc,
            'cta'      => $b->cta_label,
            'ctaHref'  => $b->cta_href,
            'badge'    => $b->badge,
            'image'    => $b->image ? '/storage/'.$b->image : null,
            '_sort_at' => $b->created_at,
        ]);

        $beritaSlides = Berita::featured()->published()
            ->with('kategoris')
            ->latest('published_at')
            ->get()
            ->map(fn (Berita $b) => [
                'tag'      => $b->kategoris->first()?->name ?? 'Berita',
                'date'     => $b->published_at->format('d.m.Y'),
                'title'    => $b->title,
                'desc'     => $b->excerpt,
                'cta'      => 'Baca Selengkapnya',
                'ctaHref'  => '/berita/'.$b->slug,
                'badge'    => 'BERITA TERBARU',
                'image'    => $b->cover_image ? '/storage/'.$b->cover_image : null,
                '_sort_at' => $b->published_at,
            ]);

        $slides = collect([...$bannerSlides, ...$beritaSlides])
            ->sortByDesc('_sort_at')
            ->map(fn ($s) => collect($s)->except('_sort_at')->all())
            ->values()
            ->all();

        return Inertia::render('Home', [
            'slides' => $slides,
            'beritaTerbaru' => Berita::published()
                ->with('kategoris')
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(fn (Berita $b) => [
                    'slug' => $b->slug,
                    'title' => $b->title,
                    'excerpt' => $b->excerpt,
                    'date' => $b->published_at->format('d.m.Y'),
                    'date_full' => $b->published_at->locale('id')->translatedFormat('d F Y'),
                    'categories' => $b->kategoris->pluck('name'),
                ]),
            'kompetensi' => Kompetensi::active()
                ->orderBy('display_order')
                ->get()
                ->map(fn (Kompetensi $k) => [
                    'slug' => $k->slug,
                    'code' => $k->code,
                    'name' => $k->name,
                    'tag' => $k->tag,
                    'short_desc' => $k->short_desc,
                    'logo_image' => $k->logo_image ? '/storage/'.$k->logo_image : null,
                ]),
            'stats' => $this->buildStats(),
        ]);
    }

    private function buildStats(): array
    {
        $totalSiswa      = DB::table('rekap_siswa')->selectRaw('SUM(laki_laki + perempuan) as total')->value('total') ?? 0;
        $kompetensiCount = Kompetensi::active()->count();
        $manualStats     = SchoolStat::active()->orderBy('display_order')->get()->values();

        return [
            ['value' => number_format((int) $totalSiswa, 0, ',', '.'), 'label' => 'Peserta Didik'],
            ['value' => $manualStats->get(0)?->value ?? '—', 'label' => $manualStats->get(0)?->label ?? 'Guru & Staff'],
            ['value' => $manualStats->get(1)?->value ?? '—', 'label' => $manualStats->get(1)?->label ?? 'Laboratorium'],
            ['value' => (string) $kompetensiCount,             'label' => 'Kompetensi'],
            ['value' => $manualStats->get(2)?->value ?? '—', 'label' => $manualStats->get(2)?->label ?? 'Penghargaan'],
            ['value' => $manualStats->get(3)?->value ?? '—', 'label' => $manualStats->get(3)?->label ?? 'Luas Tanah'],
        ];
    }
}
