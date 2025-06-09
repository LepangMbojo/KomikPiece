<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
  public function run(): void
    {
        // Array berisi nama-nama genre yang akan dimasukkan ke dalam database
        $genres = [
           'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 
            'Horror', 'Romance', 'Sci-Fi', 'Slice of Life', 'Sports',
            'Supernatural', 'Thriller', 'Mystery', 'Historical'
        ];

        // Lakukan perulangan untuk setiap nama genre di dalam array
        foreach ($genres as $genreName) {
            // firstOrCreate akan mencari genre dengan slug yang sama.
            // Jika tidak ada, ia akan membuat record baru.
            // Ini mencegah duplikasi jika seeder dijalankan lebih dari sekali.
            Genre::firstOrCreate(
                [
                    // Data untuk dicari
                    'slug' => Str::slug($genreName)
                ],
                [
                    // Data untuk dibuat jika tidak ditemukan
                    'name' => $genreName
                ]
            );
        }
    }
}
