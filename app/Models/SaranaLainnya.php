<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaLainnya extends Model
{
    protected $table = 'sarana_lainnya';

    protected $fillable = ['title', 'lead', 'items'];

    protected $casts = [
        'items' => 'array',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Sarana Prasarana Lainnya',
            'lead'  => 'Fasilitas penunjang lain di lingkungan SMK Negeri 2 Cimahi.',
            'items' => [
                [
                    'nama' => 'Gedung A',
                    'detail' => [
                        ['nama' => 'Resepsionis', 'lantai' => null],
                        ['nama' => 'Ruang Tamu', 'lantai' => null],
                        ['nama' => 'Ruang Waka Kesiswaan', 'lantai' => null],
                        ['nama' => 'Ruang Waka Kurikulum', 'lantai' => null],
                        ['nama' => 'Ruang Waka Sarana Prasarana', 'lantai' => null],
                        ['nama' => 'Ruang Kepala Sekolah', 'lantai' => 'Lt. 2'],
                        ['nama' => 'Ruang Rapat', 'lantai' => 'Lt. 2'],
                        ['nama' => 'Ruang BK', 'lantai' => 'Lt. 2'],
                    ],
                    'catatan' => null,
                ],
                ['nama' => 'Mesjid', 'detail' => [], 'catatan' => null],
                ['nama' => 'Perpustakaan', 'detail' => [], 'catatan' => 'AC, Internet, PC'],
                [
                    'nama' => 'Gedung E',
                    'detail' => [
                        ['nama' => 'Ruang Waka Hubungan Industri', 'lantai' => 'Lt. 2'],
                    ],
                    'catatan' => null,
                ],
                ['nama' => 'Lapangan Olah Raga', 'detail' => [], 'catatan' => 'Volley, Basket, Futsal'],
                ['nama' => 'UKS', 'detail' => [], 'catatan' => null],
                ['nama' => 'Kantin', 'detail' => [], 'catatan' => null],
                ['nama' => 'Koperasi', 'detail' => [], 'catatan' => null],
            ],
        ]);
    }
}
