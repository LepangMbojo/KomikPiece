<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KomikIndex;

class KomikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KomikIndex::factory(10)->create();
    }
}
