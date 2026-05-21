<?php

namespace Database\Seeders;

use App\Models\BkkLowongan;
use App\Models\BkkSetting;
use Illuminate\Database\Seeder;

class BkkSeeder extends Seeder
{
    public function run(): void
    {
        BkkSetting::updateOrCreate(['id' => 1], [
            'about' => '<p>Bursa Kerja Khusus (BKK) adalah sebuah lembaga yang dibentuk di Sekolah Menengah Kejuruan Negeri dan Swasta, sebagai unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pelaksana pemasaran, penyaluran, dan penempatan tenaga kerja, merupakan <strong>mitra Dinas Tenaga Kerja dan Transmigrasi</strong>.</p><p>BKK SMK Negeri 2 Cimahi berperan sebagai penghubung antara lulusan dengan industri, memastikan setiap tamatan mendapatkan kesempatan terbaik untuk berkarir di bidang yang sesuai dengan kompetensi mereka.</p>',
            'tujuan' => [
                ['num' => '01', 'tag' => 'WADAH', 'title' => 'Mempertemukan tamatan dengan pencari kerja', 'desc' => 'Sebagai wadah utama yang menjembatani lulusan SMKN 2 Cimahi dengan perusahaan-perusahaan yang membutuhkan tenaga kerja kompeten.'],
                ['num' => '02', 'tag' => 'LAYANAN', 'title' => 'Pelayanan tamatan yang terstruktur', 'desc' => 'Memberikan layanan kepada tamatan sesuai dengan tugas dan fungsi masing-masing seksi yang ada dalam BKK.'],
                ['num' => '03', 'tag' => 'PELATIHAN', 'title' => 'Pelatihan sesuai kebutuhan industri', 'desc' => 'Sebagai wadah pelatihan tamatan yang sesuai dengan permintaan pencari kerja, memastikan kompetensi siap pakai.'],
                ['num' => '04', 'tag' => 'WIRAUSAHA', 'title' => 'Menanamkan jiwa wirausaha', 'desc' => 'Sebagai wadah untuk menanamkan jiwa wirausaha bagi tamatan melalui pelatihan kewirausahaan dan pendampingan.'],
            ],
            'perusahaan' => [
                'PT Denso', 'PT Ateja', 'PT Medion', 'PT DMK',
                'PT Alkindo', 'PT Essei Perbama', 'Pusdatin Kemendikbud',
                'PT Patopo', 'PT CGNPM', 'PT BUMA', 'PT Bina Muda',
            ],
        ]);

        $lowongans = [
            ['title' => 'PT Caltesys — Lowongan Operator Produksi', 'company' => 'PT Caltesys', 'status' => 'AKTIF', 'category' => 'Lowongan', 'display_order' => 1],
            ['title' => 'PT Perusahaan Industri Ceres — Operator Mesin Produksi', 'company' => 'PT Industri Ceres', 'status' => 'AKTIF', 'category' => 'Lowongan', 'display_order' => 2],
            ['title' => 'PT Bukit Makmur Mandiri Utama — Multiple Positions', 'company' => 'PT BUMA', 'status' => 'AKTIF', 'category' => 'Lowongan', 'display_order' => 3],
        ];

        foreach ($lowongans as $l) {
            BkkLowongan::firstOrCreate(['title' => $l['title']], $l);
        }
    }
}
