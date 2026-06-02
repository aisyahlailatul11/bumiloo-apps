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
    Schema::table('tb_pendaftaran', function (Blueprint $table) {
        // Menambahkan kolom email setelah kolom no_hp
        $table->string('email')->nullable()->after('no_hp');
    });
}

public function down()
{
    Schema::table('tb_pendaftaran', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}
};
