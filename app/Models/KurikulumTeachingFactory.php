<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumTeachingFactory extends Model
{
    protected $table = 'kurikulum_teaching_factory';

    protected $fillable = [
        'title', 'lead', 'tagline', 'about', 'produk', 'fasilitas', 'stats',
    ];

    protected $casts = [
        'produk'    => 'array',
        'fasilitas' => 'array',
        'stats'     => 'array',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title'   => 'Teaching Factory',
            'lead'    => 'Model pembelajaran berbasis produksi nyata yang menghubungkan siswa langsung dengan dunia industri.',
            'tagline' => 'Belajar sambil berkarya, berkarya untuk industri.',
            'about'   => 'Teaching Factory (TEFA) adalah model pembelajaran vokasi yang mengintegrasikan proses produksi barang/jasa nyata ke dalam kegiatan belajar mengajar. Di SMKN 2 Cimahi, siswa tidak hanya belajar teori, tetapi langsung memproduksi produk atau jasa yang memiliki nilai ekonomi dan memenuhi standar industri.',
            'produk'  => [
                ['nama' => 'Produk Animasi & Konten Digital', 'deskripsi' => 'Motion graphic, ilustrasi digital, dan konten kreatif yang diproduksi oleh siswa Animasi dan DKV.', 'kompetensi' => 'Animasi / DKV'],
                ['nama' => 'Aplikasi & Sistem Informasi', 'deskripsi' => 'Aplikasi web dan mobile yang dikembangkan siswa RPL untuk kebutuhan nyata sekolah dan mitra.', 'kompetensi' => 'RPL'],
                ['nama' => 'Produk Kimia Industri', 'deskripsi' => 'Produk analisis dan pengujian kimia sesuai standar laboratorium industri.', 'kompetensi' => 'Kimia Industri'],
                ['nama' => 'Komponen & Perakitan Mesin', 'deskripsi' => 'Produk permesinan presisi dari mesin CNC dan konvensional yang memenuhi toleransi industri.', 'kompetensi' => 'Teknik Pemesinan'],
                ['nama' => 'Sistem Otomasi & Robotik', 'deskripsi' => 'Rancangan dan prototipe sistem otomasi yang dikembangkan siswa Mekatronika.', 'kompetensi' => 'Teknik Mekatronika'],
            ],
            'fasilitas' => [
                ['nama' => 'Studio Produksi Digital', 'deskripsi' => 'Studio lengkap untuk animasi, DKV, dan produksi konten dengan perangkat industri.'],
                ['nama' => 'Lab Pengembangan Software', 'deskripsi' => 'Ruang pengembangan aplikasi dengan workstation berperforma tinggi.'],
                ['nama' => 'Workshop Permesinan CNC', 'deskripsi' => 'Mesin CNC milling dan turning untuk produksi komponen presisi.'],
                ['nama' => 'Lab Otomasi & PLC', 'deskripsi' => 'Trainer PLC, robot industri mini, dan sistem conveyor untuk simulasi otomasi.'],
                ['nama' => 'Laboratorium Kimia Industri', 'deskripsi' => 'Lab analitik dengan peralatan standar industri untuk pengujian dan sintesis.'],
            ],
            'stats' => [
                ['angka' => '5', 'label' => 'Unit Produksi Aktif'],
                ['angka' => '200+', 'label' => 'Produk/Tahun'],
                ['angka' => '15+', 'label' => 'Mitra Industri'],
            ],
        ]);
    }
}
