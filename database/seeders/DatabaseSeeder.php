<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            AuthorSeeder::class,
            KompetensiSeeder::class,
            BeritaSeeder::class,
            SchoolStatsSeeder::class,
            RekapSiswaSeeder::class,
        ]);
    }
}
