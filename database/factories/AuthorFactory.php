<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        $name = fake()->name();
        $parts = explode(' ', $name);

        return [
            'name'     => $name,
            'initials' => strtoupper(substr($parts[0], 0, 1).substr($parts[1] ?? '', 0, 1)),
            'bio'      => fake()->sentence(),
            'email'    => fake()->unique()->safeEmail(),
        ];
    }
}
