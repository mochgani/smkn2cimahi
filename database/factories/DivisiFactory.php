<?php

namespace Database\Factories;

use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Divisi>
 */
class DivisiFactory extends Factory
{
    protected $model = Divisi::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'slug'          => Str::slug($name),
            'name'          => ucfirst($name),
            'description'   => fake()->sentence(),
            'display_order' => fake()->numberBetween(0, 100),
            'is_active'     => true,
        ];
    }
}
