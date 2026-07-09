<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaNonKejuruan extends Model
{
    protected $table = 'sarana_non_kejuruan';

    protected $fillable = ['title', 'lead', 'gedung'];

    protected $casts = [
        'gedung' => 'array',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Sarana Pembelajaran Non Kejuruan',
            'lead'  => 'Ruang kelas teori dan gedung penunjang pembelajaran umum di SMK Negeri 2 Cimahi.',
            'gedung' => [
                [
                    'nama' => 'Gedung E',
                    'lantai' => [
                        ['nama' => 'Lantai 1', 'keterangan' => '4 Ruang Kelas'],
                        ['nama' => 'Lantai 2', 'keterangan' => '4 Ruang Kelas'],
                        ['nama' => 'Lantai 3', 'keterangan' => '4 Ruang Kelas'],
                    ],
                    'fasilitas' => 'Internet, CCTV',
                ],
                [
                    'nama' => 'Gedung F',
                    'lantai' => [
                        ['nama' => 'Lantai 1', 'keterangan' => '3 Ruang Kelas'],
                        ['nama' => 'Lantai 2', 'keterangan' => '2 Ruang Kelas'],
                    ],
                    'fasilitas' => 'Internet, CCTV',
                ],
                [
                    'nama' => 'Gedung G',
                    'lantai' => [
                        ['nama' => null, 'keterangan' => '3 Ruang Kelas'],
                    ],
                    'fasilitas' => 'Internet, CCTV',
                ],
            ],
        ]);
    }
}
