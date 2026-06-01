<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BumilKonsultasiController extends Controller
{
    /**
     * Fungsi untuk mengajukan jadwal offline
     */
    public function ajukanJadwal(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil data pendaftaran terakhir milik user ini
$pendaftaran = DB::table('tb_pendaftaran')
    ->where('user_id', $userId)
    ->latest()
    ->first();

// 2. Proses Logika Percabangan (Update jika sudah ada, Insert jika belum ada data pendaftaran)
if ($pendaftaran) {
    DB::table('tb_pendaftaran')
        ->where('id', $pendaftaran->id)
        ->update([
            'status_konsultasi' => 'menunggu',
            'updated_at' => Carbon::now()
        ]);
} else {
    DB::table('tb_pendaftaran')->insert([
        'user_id' => $userId,
        'status_konsultasi' => 'menunggu',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);
}

        // 3. Ambil data pesan terakhir dari bidan yang bertipe 'request_offline' untuk mendapatkan id bidan
        $pesanBidan = DB::table('konsultasis')
            ->where('user_id', $userId)
            ->where('sender', 'bidan')
            ->where('tipe_pesan', 'request_offline')
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan bidan_id (jika tidak ada pesan sebelumnya, pakai default fallback atau kosongkan)
        $bidanId = $pesanBidan ? $pesanBidan->bidan_id : null;

        // 4. Tambahkan baris baru ke tabel 'konsultasis' sebagai tanda Bumil menyetujui / mengajukan jadwal
        DB::table('konsultasis')->insert([
            'user_id'    => $userId,
            'bidan_id'   => $bidanId,
            'pesan'      => 'Bunda menyetujui pengajuan konsultasi offline dan sedang menunggu konfirmasi jadwal dari Bidan.',
            'sender'     => 'bumil',
            'tipe_pesan' => 'text', // tipe text biasa agar muncul sebagai gelembung chat konfirmasi
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === CARI KODE INI (Mulai dari poin ke-5 di controller Anda) ===

// 5. Pastikan $pendaftaran tidak null sebelum membaca properti 'nik'
if ($pendaftaran && !empty($pendaftaran->nik)) {
    $pasienExists = DB::table('daftar_pasien')->where('nik', $pendaftaran->nik)->first();
    if ($pasienExists) {
        try {
            DB::table('daftar_pasien')
                ->where('id', $pasienExists->id)
                ->update([
                    'status_konsultasi' => 'menunggu', // Mengisi kolom status_konsultasi di daftar_pasien
                    'updated_at' => now()
                ]);
        } catch (\Exception $e) {
            // Abaikan jika terjadi kendala kolom
        }
    }
}

return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan! Pesan konfirmasi telah dikirim ke Bidan.');
    }
}