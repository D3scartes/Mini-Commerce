<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user pembeli
        User::updateOrCreate([
            'name' => 'Test Buyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
        ]);

        // Buat user penjual
        User::updateOrCreate([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
        ]);

        User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Tambahkan beberapa user dummy (optional, pakai factory)
        User::factory(5)->create();
    }
}
