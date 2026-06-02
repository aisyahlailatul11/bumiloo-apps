<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('jadwals', function (Blueprint $table) {
        // Tambahkan kolom pendaftaran_id
        $table->unsignedBigInteger('pendaftaran_id')->nullable()->after('id');

        // Opsional: Buat relasi (Foreign Key) agar datanya terikat kuat
        $table->foreign('pendaftaran_id')->references('id')->on('tb_pendaftaran')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('jadwals', function (Blueprint $table) {
        $table->dropForeign(['pendaftaran_id']);
        $table->dropColumn('pendaftaran_id');
    });
}
};
