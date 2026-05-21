<?php

namespace Database\Seeders;

use App\Models\SchoolStat;
use Illuminate\Database\Seeder;

class SchoolStatsSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['key' => 'guru-staff',   'label' => 'Guru & Staff TU',  'value' => '114',  'display_order' => 1],
            ['key' => 'laboratorium', 'label' => 'Laboratorium',      'value' => '11',   'display_order' => 2],
            ['key' => 'penghargaan',  'label' => 'Penghargaan',       'value' => '50+',  'display_order' => 3],
            ['key' => 'luas-tanah',   'label' => 'M² Luas Tanah',     'value' => '16K',  'display_order' => 4],
        ];

        foreach ($stats as $stat) {
            SchoolStat::updateOrCreate(
                ['key' => $stat['key']],
                array_merge($stat, ['is_active' => true]),
            );
        }
    }
}
