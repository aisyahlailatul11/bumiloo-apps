<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN AUTOMATIC: ADMIN
        User::create([
            'name' => 'Super Admin Bumiloo',
            'email' => 'adminbumiloo@gmail.com', // 💡 Email login admin kamu
            'password' => Hash::make('admin123'), // 💡 Password login admin
            'role' => 'Admin',
        ]);

        // 2. BUAT AKUN AUTOMATIC: BIDAN
        User::create([
            'name' => 'Bidan Siti Fatimah',
            'email' => 'sitifatimah@gmail.com', // 💡 Email login bidan kamu
            'password' => Hash::make('fatimah123'), // 💡 Password login bidan
            'role' => 'Bidan',
        ]);
    }
}