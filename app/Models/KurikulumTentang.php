<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumTentang extends Model
{
    protected $table = 'kurikulum_tentang';

    protected $fillable = [
        'title', 'lead',
        'kurikulum_nama', 'pendekatan', 'porsi_praktik', 'jumlah_mitra',
        'stats', 'filosofi',
    ];

    protected $casts = [
        'stats'    => 'array',
        'filosofi' => 'array',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'title'          => 'Kurikulum SMK Negeri 2 Cimahi',
            'lead'           => 'SMK Negeri 2 Cimahi menerapkan Kurikulum Merdeka yang diselaraskan langsung dengan kebutuhan dunia industri.',
            'kurikulum_nama' => 'Merdeka',
            'pendekatan'     => 'Link & Match',
            'porsi_praktik'  => '70%',
            'jumlah_mitra'   => '20+',
            'stats' => [
                ['num' => '70', 'em' => true, 'satuan' => '%', 'cap' => 'Pembelajaran Praktik', 'desc' => 'Porsi praktik yang besar memastikan siswa terampil, bukan sekadar paham teori.'],
                ['num' => '6',  'em' => false, 'satuan' => '', 'cap' => 'Program Keahlian', 'desc' => 'Pilihan keahlian yang luas sesuai minat siswa dan kebutuhan industri.'],
                ['num' => '20', 'em' => true, 'satuan' => '+', 'cap' => 'Mitra Industri', 'desc' => 'Jejaring industri yang memperkuat pembelajaran dan membuka peluang kerja.'],
            ],
            'filosofi' => [
                ['num' => '01', 'title' => 'Pembelajaran Mendalam', 'desc' => 'Siswa tidak sekadar menghafal. Mereka memahami, menerapkan, dan memecahkan masalah nyata.'],
                ['num' => '02', 'title' => 'Berbasis Projek', 'desc' => 'Siswa belajar melalui projek dan produk nyata sehingga keterampilan terbentuk secara utuh.'],
                ['num' => '03', 'title' => 'Karakter Pancawaluya', 'desc' => 'Kami menanamkan nilai karakter sebagai fondasi sikap kerja yang profesional.'],
            ],
        ]);
    }
}
