<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Genre;
use App\Models\KomikIndex;
use App\Models\Comments;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    $komiks = KomikIndex::factory(10)->create(); // Koleksi komik
    $genres = Genre::factory(5)->create();       // Koleksi genre
    $users  = User::factory(3)->create();        // Koleksi user

    foreach ($komiks as $komik) {
    // Random user sebagai favorit
    $randomUser = $users->random();
    $komik->favoredByUsers()->attach($randomUser->id);

    // Beberapa genre acak
    $randomGenres = $genres->random(rand(1, 3)); // 1 sampai 3 genre
    foreach ($randomGenres as $genre) {
        $komik->genres()->attach($genre->id);



    }
}
    }}





  
    




    

