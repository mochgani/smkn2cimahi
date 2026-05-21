<?php

namespace Database\Seeders;

use App\Models\Kompetensi;
use Illuminate\Database\Seeder;

class KompetensiSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/kompetensi.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data as $i => $row) {
            $sections = array_map(function ($section) {
                $section['items'] = array_map(
                    fn ($it) => ['num' => $it[0], 'title' => $it[1], 'desc' => $it[2]],
                    $section['items']
                );

                return $section;
            }, $row['sections']);

            Kompetensi::firstOrCreate(
                ['slug' => $row['slug']],
                [
                    'code' => $row['code'],
                    'name' => $row['name'],
                    'tag' => $row['tag'],
                    'short_desc' => $row['short_desc'],
                    'lead' => $row['lead'],
                    'about' => $row['about'],
                    'sections' => $sections,
                    'cta_label' => $row['cta_label'],
                    'cta_title' => $row['cta_title'],
                    'cta_text' => $row['cta_text'],
                    'display_order' => $i + 1,
                    'is_active' => $row['is_active'] ?? true,
                ]
            );
        }
    }
}
