<?php

namespace Database\Seeders;

use App\Models\Kompetensi;
use App\Models\RekapSiswa;
use Illuminate\Database\Seeder;

class RekapSiswaSeeder extends Seeder
{
    /**
     * Data awal berdasarkan total per kompetensi dari ProfilController (hardcoded lama).
     * Dibagi rata ke 3 kelas (X/XI/XII). Admin dapat memperbarui via /admin/rekap-siswas.
     *
     * Format: slug => [rombel_total, L_total, P_total]
     */
    private array $data = [
        'mekatronika' => [16, 381, 12],
        'kimia'       => [6,  219, 57],
        'dkv'         => [6,  175, 72],
        'rpl'         => [7,  176, 53],
        'animasi'     => [5,  139, 55],
        'pemesinan'   => [2,  138,  2],
    ];

    public function run(): void
    {
        foreach ($this->data as $slug => [$rombelTotal, $lTotal, $pTotal]) {
            $kompetensi = Kompetensi::where('slug', $slug)->first();
            if (! $kompetensi) {
                continue;
            }

            // Bagi ke 3 kelas, sisa ke kelas X
            $rombelPer = intdiv($rombelTotal, 3);
            $lPer      = intdiv($lTotal, 3);
            $pPer      = intdiv($pTotal, 3);

            foreach (['XI', 'XII'] as $kelas) {
                RekapSiswa::updateOrCreate(
                    ['kompetensi_id' => $kompetensi->id, 'kelas' => $kelas],
                    ['rombel' => $rombelPer, 'laki_laki' => $lPer, 'perempuan' => $pPer],
                );
            }

            // Kelas X mendapat sisa (total - 2 * per)
            RekapSiswa::updateOrCreate(
                ['kompetensi_id' => $kompetensi->id, 'kelas' => 'X'],
                [
                    'rombel'    => $rombelTotal - ($rombelPer * 2),
                    'laki_laki' => $lTotal - ($lPer * 2),
                    'perempuan' => $pTotal - ($pPer * 2),
                ],
            );
        }
    }
}
