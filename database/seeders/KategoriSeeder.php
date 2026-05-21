<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['name' => 'Info', 'color' => '#3b82f6'],
            ['name' => 'Kegiatan', 'color' => '#0d6e3f'],
            ['name' => 'Prestasi', 'color' => '#f59e0b'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::firstOrCreate(['name' => $kat['name']], $kat);
        }
    }
}
