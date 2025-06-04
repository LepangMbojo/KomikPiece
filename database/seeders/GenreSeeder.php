<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
  public function run(): void
    {
        $genres = [
            ['name' => 'Action', 'description' => 'High-energy comics with fighting and adventure'],
            ['name' => 'Romance', 'description' => 'Love stories and romantic relationships'],
            ['name' => 'Comedy', 'description' => 'Funny and humorous comics'],
            ['name' => 'Drama', 'description' => 'Emotional and dramatic storylines'],
            ['name' => 'Fantasy', 'description' => 'Magical worlds and supernatural elements'],
            ['name' => 'Sci-Fi', 'description' => 'Science fiction and futuristic themes'],
            ['name' => 'Horror', 'description' => 'Scary and suspenseful stories'],
            ['name' => 'Slice of Life', 'description' => 'Everyday life and realistic situations'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre); // Pastikan menggunakan 'name', bukan 'name_genre'
        }
    }
}
