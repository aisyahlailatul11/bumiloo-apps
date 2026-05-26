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
    Schema::table('perkembangan', function (Blueprint $table) {
        // Menambahkan kolom jenis_layanan
        $table->string('jenis_layanan')->nullable();
    });
}

public function down()
{
    Schema::table('perkembangan', function (Blueprint $table) {
        $table->dropColumn('jenis_layanan');
    });
}
};
