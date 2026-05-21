<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanRequest;
use App\Mail\PesanKontakMail;
use App\Models\KontakSetting;
use App\Models\Kompetensi;
use App\Models\Pesan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class KontakController extends Controller
{
    public function index(): Response
    {
        $setting = KontakSetting::instance();

        $kompetensiByBidang = Kompetensi::active()
            ->orderBy('display_order')
            ->get(['slug', 'code', 'name', 'tag'])
            ->groupBy('tag')
            ->map(fn ($items, $tag) => [
                'tag'   => $tag,
                'name'  => $tag,
                'items' => $items->map(fn ($k) => [
                    'code' => $k->code,
                    'name' => $k->name,
                    'href' => '/kompetensi/' . $k->slug,
                ])->values()->all(),
            ])
            ->values()
            ->all();

        return Inertia::render('Kontak', [
            'maps_embed_url'     => $setting->maps_embed_url,
            'maps_address_short' => $setting->maps_address_short,
            'maps_address_full'  => $setting->maps_address_full,
            'kanal'              => $setting->kanal ?? [],
            'bagian'             => $setting->bagian ?? [],
            'social'             => $setting->social ?? [],
            'kompetensiByBidang' => $kompetensiByBidang,
        ]);
    }

    public function store(StorePesanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $pesan = Pesan::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'telepon' => $data['telepon'] ?? null,
            'topik' => $data['subjek'],
            'pesan' => $data['pesan'],
        ]);

        try {
            Mail::to(config('mail.from.address'))->send(new PesanKontakMail($pesan));
        } catch (\Throwable $e) {
            // Email failure should not break the user flow — log and continue.
            Log::error('Gagal kirim email notifikasi kontak: ' . $e->getMessage(), [
                'pesan_id' => $pesan->id,
            ]);
        }

        return redirect()
            ->route('kontak.index')
            ->with('success', 'Pesan Anda telah terkirim. Kami akan merespon dalam 1×24 jam.');
    }
}
