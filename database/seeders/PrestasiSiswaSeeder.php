<?php

namespace Database\Seeders;

use App\Models\PrestasiSiswa;
use Illuminate\Database\Seeder;

class PrestasiSiswaSeeder extends Seeder
{
    /**
     * Data prestasi siswa hasil scrape dari https://smkn2cmi.sch.id/prestasi/
     * (2026-07-06). Berisi 73 entri terverifikasi dari 3 tahun ajaran
     * (2022-2023, 2023-2024, 2024-2025). Situs sumber menampilkan total
     * 94 entri, namun tab "2022-2023" ternyata menampilkan data duplikat
     * dari tab lain saat di-scrape (kemungkinan besar tab berbasis
     * JavaScript yang tidak konsisten ke alat scraping) — hanya 18 entri
     * unik yang terverifikasi untuk tahun ajaran tersebut, sisanya
     * (identik dengan 2023-2024) tidak dimasukkan agar tidak duplikat.
     */
    public function run(): void
    {
        PrestasiSiswa::query()->delete();

        $jsonPath = database_path('seeders/data/prestasi_siswa.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data as $i => $row) {
            PrestasiSiswa::create([
                'nama_siswa'     => $row['nama_siswa'],
                'judul_kegiatan' => $row['judul_kegiatan'],
                'bulan_tahun'    => $row['bulan_tahun'] ?: null,
                'lokasi'         => $row['lokasi'] ?: null,
                'peringkat'      => $row['peringkat'] ?: null,
                'tingkat'        => $row['tingkat'],
                'tahun_ajaran'   => $row['tahun_ajaran'],
                'display_order'  => $i,
                'is_active'      => true,
            ]);
        }
    }
}
