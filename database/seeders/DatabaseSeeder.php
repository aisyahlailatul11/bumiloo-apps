<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Admin Otomatis yang datanya PASTI BENAR & VERIFIED
        User::create([
            'name' => 'Super Admin Bumiloo',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Admin', // Memastikan role-nya Admin (A besar)
            'email_verified_at' => now(), // Bypass Satpam Middleware Verified
        ]);
    }
}