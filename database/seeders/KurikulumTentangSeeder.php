<?php

namespace Database\Seeders;

use App\Models\KurikulumTentang;
use Illuminate\Database\Seeder;

class KurikulumTentangSeeder extends Seeder
{
    public function run(): void
    {
        KurikulumTentang::instance();
    }
}
