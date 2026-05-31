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
        $table->string('status_konsultasi')->nullable(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('tb_pendaftaran', function (Blueprint $table) {
        $table->dropColumn('status_konsultasi');
    });
}
};
