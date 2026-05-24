public function up(): void
{
    Schema::create('konsultasis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // ID Pasien yang mengirim/menerima chat
        $table->unsignedBigInteger('bidan_id')->nullable(); // ID Bidan lawan bicaranya
        $table->text('pesan'); // Isi pesan chat
        $table->string('sender'); // Penanda siapa yang mengirim: 'bumil' atau 'bidan'
        $table->timestamps(); // Mengatur waktu otomatis (created_at) sebagai jam kirim chat
    });
}