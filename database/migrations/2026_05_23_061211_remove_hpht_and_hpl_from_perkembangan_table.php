<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Sintaks untuk menghapus kolom
            $table->dropColumn(['hpht', 'hpl']);
        });
    }

    public function down(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Sintaks mengembalikan kolom jika di-rollback
            $table->date('hpht')->nullable();
            $table->date('hpl')->nullable();
        });
    }
};