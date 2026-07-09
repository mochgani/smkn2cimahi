<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaKejuruan extends Model
{
    protected $table = 'sarana_kejuruan';

    protected $fillable = ['title', 'lead', 'groups'];

    protected $casts = [
        'groups' => 'array',
    ];

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Sarana Pembelajaran Kejuruan',
            'lead'  => 'Laboratorium dan bengkel praktik untuk tiap kompetensi keahlian di SMK Negeri 2 Cimahi.',
            'groups' => [
                [
                    'kompetensi' => 'Teknik Elektronika (Mekatronika)',
                    'ruangan' => [
                        'CAE Meka', 'Meka COE 1', 'Meka COE 2', 'Meka COE 3', 'Meka COE 4', 'Meka COE 5',
                        'Meka Lab Listrik', 'Meka Lab Komputer 1', 'Meka Lab Komputer 2',
                        'Meka RPS 1', 'Meka RPS 2',
                    ],
                ],
                [
                    'kompetensi' => 'Desain Komunikasi Visual',
                    'ruangan' => ['Lab DKV A', 'Lab DKV B', 'Lab DKV C', 'Lab Tefa DKV'],
                ],
                [
                    'kompetensi' => 'Pengembangan Perangkat Lunak dan Gim (PPLG)',
                    'ruangan' => ['Lab. RPL 1', 'Lab. RPL 2', 'Lab. RPL 3', 'Lab Tefa PPLG'],
                ],
                [
                    'kompetensi' => 'Animasi',
                    'ruangan' => ['Lab Animasi 1', 'Lab Animasi 2', 'Lab Animasi 3'],
                ],
                [
                    'kompetensi' => 'Kimia Industri',
                    'ruangan' => ['Lab Kimia 1', 'Lab Kimia 2', 'Lab Kimia 3'],
                ],
                [
                    'kompetensi' => 'Teknik Mesin',
                    'ruangan' => [
                        'Bengkel Kerja Bangku', 'Bengkel Pekerjaan Bubut', 'Bengkel Pekerjaan Frais',
                        'Lab. Komputer Mesin/CNC', 'Ruang Gambar', 'Ruang Teori', 'Lab Komputer',
                    ],
                ],
            ],
        ]);
    }
}
