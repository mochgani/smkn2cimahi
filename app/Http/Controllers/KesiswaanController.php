<?php

namespace App\Http\Controllers;

use App\Models\RekapSiswa;
use Inertia\Inertia;
use Inertia\Response;

class KesiswaanController extends Controller
{
    public function rekapSiswa(): Response
    {
        $rows = RekapSiswa::with('kompetensi')
            ->get()
            ->groupBy('kompetensi_id');

        // Aggregate per kelas (X, XI, XII) untuk summary cards
        $perKelas = RekapSiswa::selectRaw('kelas, SUM(rombel) as rombel, SUM(laki_laki) as L, SUM(perempuan) as P')
            ->groupBy('kelas')
            ->get()
            ->keyBy('kelas');

        $totalL      = RekapSiswa::sum('laki_laki');
        $totalP      = RekapSiswa::sum('perempuan');
        $totalRombel = RekapSiswa::sum('rombel');
        $grandTotal  = $totalL + $totalP;

        $summary = [
            [
                'label'  => 'Total Peserta Didik',
                'value'  => number_format($grandTotal, 0, ',', '.'),
                'detail' => 'Rombongan belajar: '.$totalRombel,
            ],
            [
                'label'  => 'Kelas X',
                'value'  => number_format(($perKelas['X']->L ?? 0) + ($perKelas['X']->P ?? 0), 0, ',', '.'),
                'detail' => 'L: '.($perKelas['X']->L ?? 0).' · P: '.($perKelas['X']->P ?? 0),
            ],
            [
                'label'  => 'Kelas XI',
                'value'  => number_format(($perKelas['XI']->L ?? 0) + ($perKelas['XI']->P ?? 0), 0, ',', '.'),
                'detail' => 'L: '.($perKelas['XI']->L ?? 0).' · P: '.($perKelas['XI']->P ?? 0),
            ],
            [
                'label'  => 'Kelas XII',
                'value'  => number_format(($perKelas['XII']->L ?? 0) + ($perKelas['XII']->P ?? 0), 0, ',', '.'),
                'detail' => 'L: '.($perKelas['XII']->L ?? 0).' · P: '.($perKelas['XII']->P ?? 0),
            ],
        ];

        // Aggregate per kompetensi untuk distribusi chart + tabel
        $distribusi = $rows->map(function ($kelasRows) {
            $kompetensi  = $kelasRows->first()->kompetensi;
            $rombel      = $kelasRows->sum('rombel');
            $l           = $kelasRows->sum('laki_laki');
            $p           = $kelasRows->sum('perempuan');

            return [
                'code'   => $kompetensi->code,
                'name'   => $kompetensi->name,
                'rombel' => $rombel,
                'L'      => $l,
                'P'      => $p,
                'total'  => $l + $p,
            ];
        })
        ->sortByDesc('total')
        ->values();

        // Hitung pct dan bar (normalize ke max)
        $maxTotal = $distribusi->max('total') ?: 1;
        $distribusi = $distribusi->map(fn ($d) => array_merge($d, [
            'pct' => $grandTotal > 0 ? round($d['total'] / $grandTotal * 100, 1) : 0,
            'bar' => round($d['total'] / $maxTotal * 100, 1),
        ]))->all();

        $totalRow = [
            'rombel' => $totalRombel,
            'L'      => number_format($totalL, 0, ',', '.'),
            'P'      => $totalP,
            'total'  => number_format($grandTotal, 0, ',', '.'),
        ];

        return Inertia::render('Kesiswaan/RekapSiswa', compact('summary', 'distribusi', 'totalRow'));
    }
}
