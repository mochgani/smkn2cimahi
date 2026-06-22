<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumStruktur extends Model
{
    protected $table = 'kurikulum_struktur';

    protected $fillable = ['title', 'lead', 'phases', 'groups', 'allocation'];

    protected $casts = [
        'phases'     => 'array',
        'groups'     => 'array',
        'allocation' => 'array',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Struktur Kurikulum',
            'lead'  => 'Kurikulum disusun secara bertahap mengikuti perkembangan siswa, memastikan dasar yang kuat sebelum mendalami keahlian spesifik.',
            'phases' => [
                [
                    'step'  => 'E',
                    'kelas' => 'Kelas X',
                    'title' => 'Fase E',
                    'desc'  => 'Pada tahun pertama, siswa mempelajari dasar-dasar kejuruan dan mata pelajaran umum. Di tahap ini siswa mengenal seluruh lingkup program keahlian sebelum menentukan konsentrasi.',
                ],
                [
                    'step'  => 'F',
                    'kelas' => 'Kelas XI & XII',
                    'title' => 'Fase F',
                    'desc'  => 'Siswa mendalami konsentrasi keahlian yang dipilih. Pembelajaran berfokus pada kompetensi spesifik, praktik industri, dan persiapan sertifikasi.',
                ],
            ],
            'groups' => [
                ['title' => 'Kelompok Umum',            'desc' => 'Membentuk landasan sikap, pengetahuan umum, dan kewarganegaraan.'],
                ['title' => 'Kelompok Kejuruan',        'desc' => 'Membangun kompetensi inti sesuai program keahlian.'],
                ['title' => 'Mata Pelajaran Pilihan',   'desc' => 'Memberi ruang siswa memperdalam minat tertentu.'],
            ],
            'allocation' => [
                ['kelompok' => 'Umum',     'mata_pelajaran' => '', 'alokasi' => ''],
                ['kelompok' => 'Kejuruan', 'mata_pelajaran' => '', 'alokasi' => ''],
                ['kelompok' => 'Pilihan',  'mata_pelajaran' => '', 'alokasi' => ''],
            ],
        ]);
    }
}
