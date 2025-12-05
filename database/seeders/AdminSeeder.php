<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Malaya Land',
            'email' => 'admin@malayaland.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang kuat
            'email_verified_at' => now(),
        ]);
    }
}
