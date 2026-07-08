<?php

namespace Database\Seeders;

use App\Models\KontakSetting;
use Illuminate\Database\Seeder;

class KontakSettingSeeder extends Seeder
{
    public function run(): void
    {
        KontakSetting::updateOrCreate(['id' => 1], [
            'maps_embed_url'    => 'https://maps.google.com/maps?q=SMKN%202%20Cimahi%2C%20Jl.%20Kamarung%2C%20Citeureup%2C%20Cimahi%20Utara&t=&z=16&ie=UTF8&iwloc=&output=embed',
            'maps_address_short' => 'Jl. Kamarung KM 1.5 No.69, Citeureup, Cimahi Utara',
            'maps_address_full'  => "Jl. Kamarung KM 1.5 No.69\nCiteureup, Cimahi Utara\nKota Cimahi 40512\nJawa Barat, Indonesia",
            'kanal' => [
                ['num' => '01', 'label' => 'ALAMAT', 'value' => 'Jl. Kamarung KM 1.5 No.69', 'detail' => "Citeureup, Cimahi Utara\nKota Cimahi 40512\nJawa Barat, Indonesia", 'action' => 'Buka di Maps →', 'href' => 'https://maps.google.com/?q=SMKN+2+Cimahi+Jl+Kamarung', 'external' => true],
                ['num' => '02', 'label' => 'TELEPON', 'value' => '+62 822 9896 8928', 'detail' => "Jam operasional:\nSenin – Jumat\n07:00 – 16:00 WIB", 'action' => 'Telepon Sekarang →', 'href' => 'tel:+6282298968928', 'external' => false],
                ['num' => '03', 'label' => 'EMAIL', 'value' => 'info@smkn2cmi.sch.id', 'detail' => "Respon dalam\n1 × 24 jam kerja\n(Senin – Jumat)", 'action' => 'Kirim Email →', 'href' => 'mailto:info@smkn2cmi.sch.id', 'external' => false],
                ['num' => '04', 'label' => 'WHATSAPP', 'value' => '+62 822 9896 8928', 'detail' => "Chat langsung\nuntuk respon cepat\njam kerja", 'action' => 'Buka WhatsApp →', 'href' => 'https://wa.me/6282298968928', 'external' => true],
            ],
            'bagian' => [
                ['num' => '01', 'name' => 'Tata Usaha', 'desc' => 'Administrasi umum, surat-menyurat, legalisir, dan dokumen sekolah.', 'label' => 'EMAIL', 'href' => 'mailto:info@smkn2cmi.sch.id', 'value' => 'info@smkn2cmi.sch.id'],
                ['num' => '02', 'name' => 'PPDB / SPMB', 'desc' => 'Penerimaan Peserta Didik Baru, jalur prestasi, dan informasi pendaftaran 2026/2027.', 'label' => 'EMAIL', 'href' => 'mailto:ppdb@smkn2cmi.sch.id', 'value' => 'ppdb@smkn2cmi.sch.id'],
                ['num' => '03', 'name' => 'Bursa Kerja Khusus (BKK)', 'desc' => 'Rekrutmen lulusan, info lowongan kerja, dan kerja sama dengan industri.', 'label' => 'HALAMAN', 'href' => '/hubungan-industri/bkk', 'value' => 'Lihat halaman BKK →'],
                ['num' => '04', 'name' => 'Hubungan Industri', 'desc' => 'Kerja sama IDUKA, MoU, kelas industri, kunjungan industri, dan PKL siswa.', 'label' => 'EMAIL', 'href' => 'mailto:hubin@smkn2cmi.sch.id', 'value' => 'hubin@smkn2cmi.sch.id'],
                ['num' => '05', 'name' => 'Kesiswaan', 'desc' => 'OSIS, ekstrakurikuler, prestasi siswa, dan kegiatan kesiswaan.', 'label' => 'HALAMAN', 'href' => '/kesiswaan/rekap-siswa', 'value' => 'Lihat data kesiswaan →'],
                ['num' => '06', 'name' => 'Tim ICT & Media', 'desc' => 'Website sekolah, kontribusi berita, kerja sama media, dan press release.', 'label' => 'EMAIL', 'href' => 'mailto:ict@smkn2cmi.sch.id', 'value' => 'ict@smkn2cmi.sch.id'],
            ],
            'social' => [
                ['num' => '01', 'label' => 'INSTAGRAM', 'handle' => '@smkn2_cimahi', 'href' => 'https://www.instagram.com/smkn2_cimahi/'],
                ['num' => '02', 'label' => 'FACEBOOK',  'handle' => '/smkn2cmi',      'href' => 'https://www.facebook.com/smkn2cmi'],
                ['num' => '03', 'label' => 'YOUTUBE',   'handle' => 'SMK Negeri 2 Cimahi', 'href' => 'https://www.youtube.com/channel/UCzEQqJgk4F0UulngS94Ql3g'],
                ['num' => '04', 'label' => 'LINKEDIN',  'handle' => 'SMK Negeri 2 Cimahi', 'href' => 'https://id.linkedin.com/school/smk-negeri-2-cimahi'],
            ],
        ]);
    }
}
