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