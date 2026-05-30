<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name'  => ucfirst($name),
            'slug'  => Str::slug($name),
            'color' => fake()->safeHexColor(),
        ];
    }
}
