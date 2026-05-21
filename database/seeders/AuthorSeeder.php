<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::firstOrCreate(
            ['name' => 'TIM Penulis'],
            [
                'initials' => 'TP',
                'bio' => 'Tim editorial SMK Negeri 2 Cimahi yang menyajikan kabar terbaru dari sekolah—dari kegiatan akademik, prestasi siswa, hingga pengumuman penting untuk warga sekolah dan publik.',
                'email' => 'editorial@smkn2cmi.sch.id',
            ]
        );
    }
}
