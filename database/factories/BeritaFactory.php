<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
{
    protected $model = Berita::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'slug'                 => Str::slug($title).'-'.Str::random(5),
            'title'                => $title,
            'excerpt'              => fake()->paragraph(2),
            'content'              => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'cover_image'          => null,
            'tags'                 => fake()->words(3),
            'reading_time_minutes' => fake()->numberBetween(2, 10),
            'is_featured'          => false,
            'is_published'         => true,
            'published_at'         => now()->subDays(fake()->numberBetween(0, 30)),
            'author_id'            => null,
            'created_by'           => null,
            'kompetensi_id'        => null,
            'divisi_id'            => null,
            'approval_status'      => 'approved',
            'approved_by'          => null,
            'approved_at'          => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'is_published'    => false,
            'approval_status' => 'draft',
            'approved_at'     => null,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'is_published'    => false,
            'approval_status' => 'pending',
            'approved_at'     => null,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn () => [
            'is_published'    => false,
            'approval_status' => 'rejected',
            'approved_at'     => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function unpublished(): static
    {
        return $this->state(fn () => [
            'is_published' => false,
            'published_at' => now()->addDays(7),
        ]);
    }
}
