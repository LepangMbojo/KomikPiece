<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;
use App\Models\KomikIndex;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'content' => $this->faker->sentence(),
            'user_id' => User::factory(),         // relasi ke user
            'komik_index_id' => KomikIndex::factory(),  // relasi ke komik
        ];
    }
}
