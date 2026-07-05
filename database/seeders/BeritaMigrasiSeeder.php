<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BeritaMigrasiSeeder extends Seeder
{
    /**
     * Ganti seluruh isi tabel beritas dengan data asli dari web utama
     * https://smkn2cmi.sch.id/berita/ (34 artikel, di-scrape 2026-07-05).
     * Cover image sengaja dikosongkan — akan diupload manual via admin.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/berita_migrasi.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        $author = Author::where('name', 'TIM Penulis')->first();
        $admin  = User::where('email', 'admin@smkn2cmi.sch.id')->first();

        DB::transaction(function () use ($data, $author, $admin) {
            DB::table('berita_kategori')->delete();
            Berita::query()->delete();

            foreach ($data as $row) {
                $content = collect($row['content_paragraphs'])
                    ->map(fn (string $p) => '<p>'.e($p).'</p>')
                    ->implode("\n");

                $wordCount = str_word_count(implode(' ', $row['content_paragraphs']));
                $readingTime = max(1, (int) ceil($wordCount / 200));

                $publishedAt = $row['published_at'].' 08:00:00';

                $berita = Berita::create([
                    'slug'                  => Str::slug($row['title']),
                    'title'                 => $row['title'],
                    'excerpt'               => $row['excerpt'],
                    'content'               => $content,
                    'reading_time_minutes'  => $readingTime,
                    'tags'                  => $row['categories'],
                    'is_featured'           => false,
                    'is_published'          => true,
                    'published_at'          => $publishedAt,
                    'author_id'             => $author?->id,
                    'created_by'            => $admin?->id,
                    'approval_status'       => 'approved',
                    'approved_by'           => $admin?->id,
                    'approved_at'           => $publishedAt,
                ]);

                $kategoriIds = Kategori::whereIn('name', $row['categories'])->pluck('id');
                if ($kategoriIds->isNotEmpty()) {
                    $berita->kategoris()->sync($kategoriIds);
                }
            }
        });
    }
}
