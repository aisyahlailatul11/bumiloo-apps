<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name'  => 'Super Admin',
            'email' => 'adminbumiloo@gmail.com',
            'password' => Hash::make('admin123'),
            'role'  => 'Admin',
            'email_verified_at' => now(),
        ]);

        // 2. Akun Bidan
        User::create([
            'name'  => 'Siti Fatimah',
            'email' => 'sitifatimah@gmail.com',
            'password' => Hash::make('fatimah123'),
            'role'  => 'Bidan',
            'email_verified_at' => now(),
        ]);
    }
}