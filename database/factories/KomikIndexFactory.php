<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KomikIndex;
use App\Models\User;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KomikIndexFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'cover' => fake()->imageUrl(640, 480, 'komik', true),
            'rating' => fake()->numberBetween(1, 5),
            'chapter' => fake()->numberBetween(1, 100),
            'status' => fake()->randomElement(['Ongoing', 'Completed']),
            'language' => fake()->randomElement(['English', 'Indonesian', 'Japanese']),
            'description' => fake()->paragraph(),
            'author' => fake()->name(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
