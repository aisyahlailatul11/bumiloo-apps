<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Menghapus kolom jenis_pelayanan dari database
            $table->dropColumn('jenis_pelayanan');
        });
    }

    public function down(): void
    {
        Schema::table('perkembangan', function (Blueprint $table) {
            // Jika di-rollback, kolom akan dikembalikan lagi
            $table->string('jenis_pelayanan')->nullable()->after('pasien_id');
        });
    }
};