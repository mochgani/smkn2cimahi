<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $author = Author::where('name', 'TIM Penulis')->first();

        $jsonPath = database_path('seeders/data/berita.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        foreach ($data as $row) {
            $berita = Berita::firstOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'excerpt' => $row['excerpt'],
                    'content' => $row['content'] ?? "<p>{$row['excerpt']}</p>",
                    'reading_time_minutes' => (int) filter_var($row['reading_time'] ?? '3', FILTER_SANITIZE_NUMBER_INT),
                    'is_featured' => $row['is_featured'] ?? false,
                    'is_published' => true,
                    'published_at' => $row['date_iso'] ?? now(),
                    'author_id' => $author?->id,
                ]
            );

            $kategoriIds = Kategori::whereIn('name', $row['categories'])->pluck('id');
            $berita->kategoris()->sync($kategoriIds);
        }
    }
}
