<?php

namespace Database\Factories;

use App\Models\Kompetensi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Kompetensi>
 */
class KompetensiFactory extends Factory
{
    protected $model = Kompetensi::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'slug'          => Str::slug($name),
            'code'          => strtoupper(Str::random(3)),
            'name'          => ucfirst($name),
            'tag'           => fake()->randomElement(['Teknologi Informasi', 'Seni & Desain', 'Teknik Industri']),
            'short_desc'    => fake()->sentence(),
            'lead'          => fake()->paragraph(),
            'about'         => '<p>'.fake()->paragraph(3).'</p>',
            'sections'      => [],
            'cta_label'     => 'Daftar Sekarang',
            'cta_href'      => '#',
            'display_order' => fake()->numberBetween(0, 100),
            'is_active'     => true,
            'logo_image'    => null,
            'gallery'       => [],
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
