<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin default
        User::create([
            'username' => 'Admin',
            'email' => 'admin@komikpiece.com',
            'password' => Hash::make('admin123'), // Ganti dengan password yang kuat
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Buat akun admin tambahan jika diperlukan
        User::create([
            'username' => 'Super Admin',
            'email' => 'superadmin@komikpiece.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}