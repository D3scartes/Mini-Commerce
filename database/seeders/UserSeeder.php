<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user buyer contoh
        User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Test Buyer',
                'password' => Hash::make('password123'),
                'role' => 'buyer',
            ]
        );

        // Tambahkan beberapa user dummy (semua role buyer)
        User::factory(5)->create([
            'role' => 'buyer',
        ]);
    }
}
