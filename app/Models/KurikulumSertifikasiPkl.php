<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumSertifikasiPkl extends Model
{
    protected $table = 'kurikulum_sertifikasi_pkl';

    protected $fillable = [
        'title', 'lead', 'sertifikasi', 'pkl_deskripsi', 'pkl_durasi', 'pkl_min_nilai', 'alur_pkl',
    ];

    protected $casts = [
        'sertifikasi' => 'array',
        'alur_pkl'    => 'array',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Sertifikasi & PKL',
            'lead'  => 'Setiap lulusan SMKN 2 Cimahi dibekali sertifikasi kompetensi nasional dan pengalaman kerja nyata melalui Praktik Kerja Lapangan.',
            'sertifikasi' => [
                ['nama' => 'Sertifikat Kompetensi LSP', 'lembaga' => 'LSP P1 SMKN 2 Cimahi', 'deskripsi' => 'Sertifikasi kompetensi keahlian yang dilaksanakan oleh Lembaga Sertifikasi Profesi Pihak Pertama terakreditasi BNSP.', 'kompetensi' => 'Semua Program'],
                ['nama' => 'Sertifikasi Internasional Mekatronika', 'lembaga' => 'AHK / GDVET', 'deskripsi' => 'Sertifikat kompetensi berstandar Jerman untuk siswa Teknik Mekatronika yang mengikuti program kelas Bayer.', 'kompetensi' => 'Teknik Mekatronika'],
                ['nama' => 'Sertifikasi Software Development', 'lembaga' => 'Vendor Teknologi', 'deskripsi' => 'Sertifikat vendor terkait pengembangan aplikasi dan pemrograman untuk siswa RPL.', 'kompetensi' => 'RPL'],
                ['nama' => 'Sertifikat K3 Industri', 'lembaga' => 'Kemnaker RI', 'deskripsi' => 'Sertifikat Keselamatan dan Kesehatan Kerja untuk semua program keahlian.', 'kompetensi' => 'Semua Program'],
            ],
            'pkl_deskripsi' => 'Praktik Kerja Lapangan (PKL) merupakan bagian integral dari kurikulum vokasi yang memberikan pengalaman kerja nyata di industri. Siswa ditempatkan di perusahaan mitra selama minimal 6 bulan untuk menerapkan kompetensi yang telah dipelajari.',
            'pkl_durasi'    => '6 bulan',
            'pkl_min_nilai' => '75',
            'alur_pkl' => [
                ['step' => '01', 'judul' => 'Pendaftaran & Pembekalan', 'deskripsi' => 'Siswa mendaftar PKL dan mengikuti pembekalan materi K3, etika kerja, dan teknis lapangan.'],
                ['step' => '02', 'judul' => 'Penempatan di Industri', 'deskripsi' => 'Sekolah mengoordinasikan penempatan siswa di perusahaan mitra sesuai program keahlian.'],
                ['step' => '03', 'judul' => 'Pelaksanaan PKL', 'deskripsi' => 'Siswa bekerja di industri selama 6 bulan dengan bimbingan instruktur dari perusahaan dan guru pembimbing.'],
                ['step' => '04', 'judul' => 'Monitoring & Evaluasi', 'deskripsi' => 'Guru pembimbing melakukan kunjungan monitoring minimal 2 kali selama periode PKL.'],
                ['step' => '05', 'judul' => 'Laporan & Ujian PKL', 'deskripsi' => 'Siswa menyusun laporan PKL dan mengikuti ujian presentasi di hadapan guru dan perwakilan industri.'],
            ],
        ]);
    }
}
