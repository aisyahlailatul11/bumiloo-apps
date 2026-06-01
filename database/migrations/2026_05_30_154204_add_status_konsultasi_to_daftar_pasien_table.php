<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // UBAH DISINI: Ganti 'daftar_pasien' menjadi 'pasien'
        Schema::table('pasien', function (Blueprint $table) {
            // Diletakkan setelah nama_suami
            $table->string('status_konsultasi')->nullable()->after('nama_suami');
        });
    }

    public function down(): void
    {
        // UBAH DISINI JUGA: Ganti 'daftar_pasien' menjadi 'pasien'
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('status_konsultasi');
        });
    }
};