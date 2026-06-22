<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTentang;
use App\Models\KurikulumStruktur;
use App\Models\Kompetensi;
use Inertia\Inertia;
use Inertia\Response;

class KurikulumController extends Controller
{
    public function programKeahlian(): Response
    {
        $programs = Kompetensi::active()
            ->orderBy('display_order')
            ->get()
            ->map(fn (Kompetensi $k, int $i) => [
                'slug'       => $k->slug,
                'code'       => $k->code,
                'name'       => $k->name,
                'tag'        => $k->tag,
                'short_desc' => $k->short_desc,
                'lead'       => $k->lead,
                'logo_image' => $k->logo_image ? '/storage/' . $k->logo_image : null,
                'num'        => 'P-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
            ])
            ->all();

        return Inertia::render('Kurikulum/ProgramKeahlian', [
            'programs' => $programs,
        ]);
    }

    public function struktur(): Response
    {
        $data = KurikulumStruktur::instance();

        return Inertia::render('Kurikulum/Struktur', [
            'struktur' => [
                'title'      => $data->title,
                'lead'       => $data->lead,
                'phases'     => $data->phases     ?? [],
                'groups'     => $data->groups     ?? [],
                'allocation' => $data->allocation ?? [],
            ],
        ]);
    }

    public function tentang(): Response
    {
        $data = KurikulumTentang::instance();

        return Inertia::render('Kurikulum/Tentang', [
            'kurikulum' => [
                'title'          => $data->title,
                'lead'           => $data->lead,
                'kurikulum_nama' => $data->kurikulum_nama,
                'pendekatan'     => $data->pendekatan,
                'porsi_praktik'  => $data->porsi_praktik,
                'jumlah_mitra'   => $data->jumlah_mitra,
                'jumlah_program' => Kompetensi::active()->count(),
                'stats'          => $data->stats ?? [],
                'filosofi'       => $data->filosofi ?? [],
            ],
        ]);
    }
}
