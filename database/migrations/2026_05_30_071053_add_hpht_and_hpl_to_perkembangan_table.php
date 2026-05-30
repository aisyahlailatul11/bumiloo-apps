<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Menambahkan kolom hpht dan hpl setelah kolom pasien_id
            $table->date('hpht')->nullable()->after('pasien_id');
            $table->date('hpl')->nullable()->after('hpht');
        });
    }

    public function down(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['hpht', 'hpl']);
        });
    }
};