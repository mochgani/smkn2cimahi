<?php

namespace Database\Seeders;

use App\Models\KurikulumMitra;
use Illuminate\Database\Seeder;

class KurikulumMitraSeeder extends Seeder
{
    public function run(): void
    {
        if (KurikulumMitra::count() > 0) return;

        $mitras = [
            [
                'field' => 'Teknik Mekatronika',
                'nama'  => 'PT Bayer Indonesia',
                'desc'  => 'Kelas mekatronika yang mengadopsi standar pendidikan vokasi Jerman melalui program GDVET dan AHK, diselaraskan dengan praktik industri berstandar internasional.',
                'tags'  => ['Penyelarasan kurikulum', 'Guru tamu', 'Pelatihan terstruktur', 'Sertifikasi'],
                'display_order' => 1,
            ],
            [
                'field' => 'Teknologi & Rekayasa',
                'nama'  => 'Cimahi Maker Space',
                'desc'  => 'Siswa belajar dalam ekosistem kreatif berbasis teknologi terapan, mengembangkan ide menjadi produk nyata dengan dukungan fasilitas dan mentor berpengalaman.',
                'tags'  => ['Pendampingan projek', 'Akses fasilitas', 'Pelatihan'],
                'display_order' => 2,
            ],
            [
                'field' => 'Animasi & DKV',
                'nama'  => 'PT Ayena Mandiri Cinema',
                'desc'  => 'Siswa belajar langsung dari pelaku industri film dan produksi kreatif, terlibat dalam proses produksi yang sesungguhnya sehingga siap memasuki industri kreatif.',
                'tags'  => ['Kelas berbasis industri', 'Proyek produksi', 'Bimbingan praktisi'],
                'display_order' => 3,
            ],
        ];

        foreach ($mitras as $mitra) {
            KurikulumMitra::create($mitra);
        }
    }
}
