<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // >>> DAFTAR ADMIN RESMI (pusat di sini) <<<
        // Tambah/hapus admin di array ini saja.
        $admins = [
            ['email' => 'admin@example.com', 'name' => 'Admin User', 'password' => 'password123'],
            ['email' => 'admin@ais.com',     'name' => 'Admin Ais',  'password' => 'aisyyaaa'],
            // contoh tambah:
            // ['email' => 'admin2@domain.com', 'name' => 'Admin Dua', 'password' => 'rahasia!'],
        ];

        // Normalisasi (buat jaga-jaga)
        $emails = [];
        foreach ($admins as $a) {
            $email = strtolower(trim($a['email']));
            $emails[] = $email;

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $a['name'] ?? 'Admin',
                    'password' => isset($a['password']) ? Hash::make($a['password']) : Hash::make('password123'),
                    'role'     => 'admin',
                ]
            );
        }

        // WHITELIST ENFORCEMENT:
        // Semua user yang role=admin tapi TIDAK ada di daftar → diturunkan ke 'user'
        if (!empty($emails)) {
            User::where('role', 'admin')
                ->whereNotIn('email', $emails)
                ->update(['role' => 'user']);
        }
    }
}
