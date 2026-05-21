<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kompetensi;
use Inertia\Inertia;
use Inertia\Response;

class KompetensiController extends Controller
{
    private function show(string $slug, string $component): Response
    {
        $kompetensi = Kompetensi::where('slug', $slug)->firstOrFail();

        $kompetensiData = $kompetensi->toArray();
        $kompetensiData['logo_image'] = $kompetensi->logo_image ? '/storage/'.$kompetensi->logo_image : null;
        $kompetensiData['gallery']    = collect($kompetensi->gallery ?? [])
            ->map(fn ($path) => '/storage/'.$path)
            ->values()
            ->all();

        $lainnya = Kompetensi::active()
            ->where('slug', '!=', $slug)
            ->orderBy('display_order')
            ->get(['slug', 'code', 'name', 'tag']);

        $beritas = Berita::published()
            ->with('kategoris')
            ->where('kompetensi_id', $kompetensi->id)
            ->latest('published_at')
            ->take(6)
            ->get()
            ->map(fn (Berita $b) => [
                'slug'         => $b->slug,
                'title'        => $b->title,
                'excerpt'      => $b->excerpt,
                'date'         => $b->published_at->format('d.m.Y'),
                'reading_time' => "{$b->reading_time_minutes} menit",
                'categories'   => $b->kategoris->pluck('name'),
            ]);

        return Inertia::render("Kompetensi/$component", [
            'kompetensi' => $kompetensiData,
            'lainnya'    => $lainnya,
            'beritas'    => $beritas,
        ]);
    }

    public function animasi(): Response { return $this->show('animasi', 'Animasi'); }
    public function dkv(): Response { return $this->show('dkv', 'DKV'); }
    public function rpl(): Response { return $this->show('rpl', 'RPL'); }
    public function kimia(): Response { return $this->show('kimia', 'Kimia'); }
    public function mekatronika(): Response { return $this->show('mekatronika', 'Mekatronika'); }
    public function pemesinan(): Response { return $this->show('pemesinan', 'Pemesinan'); }
}
