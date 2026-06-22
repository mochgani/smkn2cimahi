<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTentang;
use App\Models\Kompetensi;
use Inertia\Inertia;
use Inertia\Response;

class KurikulumController extends Controller
{
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
