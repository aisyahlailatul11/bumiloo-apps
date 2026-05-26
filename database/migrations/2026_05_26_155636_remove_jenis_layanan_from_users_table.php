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
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('jenis_layanan');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // Jika suatu saat kamu ingin membatalkan hapus (mengembalikan kolom),
        // definisikan ulang kolomnya di sini
        $table->string('jenis_layanan')->nullable();
    });
}
};
