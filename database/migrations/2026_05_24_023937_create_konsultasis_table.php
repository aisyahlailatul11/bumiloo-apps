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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID Pasien yang mengirim/menerima chat
            $table->unsignedBigInteger('bidan_id')->nullable(); // ID Bidan lawan bicaranya
            $table->text('pesan'); // Isi pesan chat
            $table->string('sender'); // Penanda siapa yang mengirim: 'bumil' atau 'bidan'
            $table->timestamps(); // Mengatur waktu otomatis (created_at) sebagai jam kirim chat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};