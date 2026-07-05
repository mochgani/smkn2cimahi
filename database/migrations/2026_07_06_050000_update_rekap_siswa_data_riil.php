<?php

use App\Models\Kompetensi;
use App\Models\RekapSiswa;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Ganti data rekap siswa (yang sebelumnya dibagi rata per kelas)
     * dengan angka riil hasil scrape dari https://smkn2cmi.sch.id/kesiswaan/
     * (2026-07-06). Catatan: Multimedia (nama lama) dipetakan ke DKV.
     * Total DKV & Pemesinan kelas XII sedikit berbeda dari angka ringkasan
     * di web lama karena tabel sumber menampilkan data tidak konsisten
     * antara rincian per kelas dan angka total — silakan cek kembali via
     * /admin/rekap-siswas bila perlu penyesuaian.
     */
    public function up(): void
    {
        $data = [
            'mekatronika' => [
                'X'   => ['rombel' => 4, 'laki_laki' => 127, 'perempuan' => 9],
                'XI'  => ['rombel' => 4, 'laki_laki' => 119, 'perempuan' => 7],
                'XII' => ['rombel' => 4, 'laki_laki' => 125, 'perempuan' => 6],
            ],
            'rpl' => [
                'X'   => ['rombel' => 3, 'laki_laki' => 75, 'perempuan' => 23],
                'XI'  => ['rombel' => 2, 'laki_laki' => 51, 'perempuan' => 14],
                'XII' => ['rombel' => 2, 'laki_laki' => 50, 'perempuan' => 16],
            ],
            'dkv' => [
                'X'   => ['rombel' => 3, 'laki_laki' => 76, 'perempuan' => 29],
                'XI'  => ['rombel' => 3, 'laki_laki' => 79, 'perempuan' => 32],
                'XII' => ['rombel' => 2, 'laki_laki' => 34, 'perempuan' => 35],
            ],
            'animasi' => [
                'X'   => ['rombel' => 2, 'laki_laki' => 58, 'perempuan' => 11],
                'XI'  => ['rombel' => 2, 'laki_laki' => 36, 'perempuan' => 27],
                'XII' => ['rombel' => 2, 'laki_laki' => 45, 'perempuan' => 17],
            ],
            'kimia' => [
                'X'   => ['rombel' => 3, 'laki_laki' => 67, 'perempuan' => 34],
                'XI'  => ['rombel' => 3, 'laki_laki' => 70, 'perempuan' => 21],
                'XII' => ['rombel' => 3, 'laki_laki' => 55, 'perempuan' => 29],
            ],
            'pemesinan' => [
                'X'   => ['rombel' => 2, 'laki_laki' => 66, 'perempuan' => 2],
                'XI'  => ['rombel' => 2, 'laki_laki' => 72, 'perempuan' => 0],
                'XII' => ['rombel' => 2, 'laki_laki' => 140, 'perempuan' => 0],
            ],
        ];

        foreach ($data as $slug => $kelasData) {
            $kompetensiId = Kompetensi::where('slug', $slug)->value('id');
            if (!$kompetensiId) {
                continue;
            }

            foreach ($kelasData as $kelas => $row) {
                RekapSiswa::updateOrCreate(
                    ['kompetensi_id' => $kompetensiId, 'kelas' => $kelas],
                    $row
                );
            }
        }
    }

    public function down(): void
    {
        // Data lama (perkiraan) tidak disimpan, tidak ada rollback.
    }
};
