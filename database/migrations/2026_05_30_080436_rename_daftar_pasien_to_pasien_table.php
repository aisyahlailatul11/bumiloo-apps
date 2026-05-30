<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Mengubah nama tabel dari daftar_pasien menjadi pasien
        Schema::rename('daftar_pasien', 'pasien');
    }

    public function down(): void
    {
        // Jika di-rollback, kembalikan namanya ke semula
        Schema::rename('pasien', 'daftar_pasien');
    }
};