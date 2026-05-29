<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Manager memanggil antrian seeder di sini
        $this->call([
            UserSeeder::class,
            BidanSeeder::class, // Pastikan file BidanSeeder sudah kamu buat juga!
        ]);
    }
}