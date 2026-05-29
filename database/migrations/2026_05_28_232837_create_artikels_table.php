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
    Schema::create('artikels', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('kategori')->nullable();
        $table->text('deskripsi');
        $table->string('gambar'); // Menyimpan nama file atau URL gambar
        $table->timestamps(); // Otomatis membuat kolom created_at & updated_at
    });
}
};