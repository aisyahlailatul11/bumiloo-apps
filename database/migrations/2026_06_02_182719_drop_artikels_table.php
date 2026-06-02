<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menghapus tabel artikels
        Schema::dropIfExists('artikels');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Jika suatu saat kamu berubah pikiran, ini perintah untuk membuat tabelnya kembali
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul_edukasi');
            $table->string('kategori');
            $table->text('konten_edukasi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }
};