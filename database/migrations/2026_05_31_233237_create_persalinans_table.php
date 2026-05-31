<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persalinan', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('perkembangan_id');
            $blueprint->unsignedBigInteger('pasien_id');

            // Tanggal Persalinan disalin dari Tanggal Pemeriksaan
            $blueprint->date('tanggal_persalinan');

            // Keadaan Umum Ibu Pasca Persalinan
            $blueprint->enum('keadaan_umum_ibu', ['Baik', 'Lemah'])->default('Baik');
            $blueprint->integer('nadi')->nullable();
            $blueprint->string('tekanan_darah')->nullable();
            $blueprint->double('hb', 4, 2)->nullable();
            $blueprint->string('uterus_kontraksi_tfu')->nullable();
            $blueprint->integer('pendarahan_kala_iii')->nullable();
            $blueprint->integer('pendarahan_kala_iv')->nullable();

            // Plasenta
            $blueprint->string('plasenta_bentuk_ukuran')->nullable();
            $blueprint->string('plasenta_tali_pusat')->nullable();
            $blueprint->string('plasenta_kulit_ketuban')->nullable();

            // Data Anak / Bayi
            $blueprint->enum('anak_jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $blueprint->enum('anak_kondisi_lahir', ['Hidup', 'Mati'])->nullable();
            $blueprint->double('anak_berat_badan', 5, 2)->nullable();
            $blueprint->integer('anak_panjang_badan')->nullable();
            $blueprint->integer('anak_lingkar_dada')->nullable();
            $blueprint->integer('anak_lingkar_kepala')->nullable();
            $blueprint->string('anak_kelainan_kongenital')->nullable(); // Menampung hasil select / teks manual
            $blueprint->integer('bayi_meninggal_menit_post_partum')->nullable();
            $blueprint->string('bayi_mati_sebab')->nullable();

            // APGAR SCORE MENIT 1 & 5
            $blueprint->integer('apgar_m1_jantung')->default(0);
            $blueprint->integer('apgar_m1_napas')->default(0);
            $blueprint->integer('apgar_m1_otot')->default(0);
            $blueprint->integer('apgar_m1_refleks')->default(0);
            $blueprint->integer('apgar_m1_warna')->default(0);
            $blueprint->integer('apgar_m1_total')->default(0);

            $blueprint->integer('apgar_m5_jantung')->default(0);
            $blueprint->integer('apgar_m5_napas')->default(0);
            $blueprint->integer('apgar_m5_otot')->default(0);
            $blueprint->integer('apgar_m5_refleks')->default(0);
            $blueprint->integer('apgar_m5_warna')->default(0);
            $blueprint->integer('apgar_m5_total')->default(0);

            // Resusitasi (Kolom intubasi HAPUS)
            $blueprint->string('resusitasi_o2')->nullable();
            $blueprint->string('resusitasi_pompa_udara')->nullable();

            // Ikhtisar Persalinan (Kolom lain_lain HAPUS)
            $blueprint->dateTime('ketuban_pecah_at')->nullable();
            $blueprint->dateTime('bayi_lahir_at')->nullable();
            $blueprint->string('macam_persalinan')->nullable(); // Menampung hasil select / teks manual
            $blueprint->string('indikasi_persalinan')->nullable();
            $blueprint->string('lama_persalinan_jam')->nullable();
            
            // Nama Dokter diubah jadi nama Bidan & Kolom QR Code
            $blueprint->string('nama_bidan')->default('Siti Fatimah, A.Md.Keb.');
            $blueprint->string('qr_signature_code')->nullable()->comment('Kode unik verifikasi TTD QR');

            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persalinan');
    }
};