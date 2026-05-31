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

        // 1. Ambil data pendaftaran milik user yang sedang login untuk validasi awal
        $pendaftaran = DB::table('tb_pendaftaran')->where('user_id', $userId)->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran Anda tidak ditemukan. Silakan lakukan pendaftaran terlebih dahulu.');
        }

        // 2. Ambil data pesan terakhir dari bidan yang bertipe 'request_offline' untuk mendapatkan id bidan
        $pesanBidan = DB::table('konsultasis')
            ->where('user_id', $userId)
            ->where('sender', 'bidan')
            ->where('tipe_pesan', 'request_offline')
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan bidan_id (jika tidak ada pesan sebelumnya, pakai default fallback atau kosongkan)
        $bidanId = $pesanBidan ? $pesanBidan->bidan_id : null;

        // 3. Tambahkan baris baru ke tabel 'konsultasis' sebagai tanda Bumil menyetujui / mengajukan jadwal
        DB::table('konsultasis')->insert([
            'user_id'    => $userId,
            'bidan_id'   => $bidanId,
            'pesan'      => 'Bunda menyetujui pengajuan konsultasi offline dan sedang menunggu konfirmasi jadwal dari Bidan.',
            'sender'     => 'bumil',
            'tipe_pesan' => 'text', // tipe text biasa agar muncul sebagai gelembung chat konfirmasi
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Jika ada tabel daftar_pasien dan memiliki kolom status_konsultasi, kita update secara opsional
        if (!empty($pendaftaran->nik)) {
            $pasienExists = DB::table('daftar_pasien')->where('nik', $pendaftaran->nik)->first();
            if ($pasienExists) {
                // Gunakan try-catch agar jika kolom tidak ada di daftar_pasien, program tidak ikut crash
                try {
                    DB::table('daftar_pasien')
                        ->where('id', $pasienExists->id)
                        ->update([
                            'status_konsultasi' => 'menunggu',
                            'updated_at' => now()
                        ]);
                } catch (\Exception $e) {
                    // Abaikan jika kolom tidak ada di daftar_pasien
                }
            }
        }

        return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan! Pesan konfirmasi telah dikirim ke Bidan.');
    }
    public function ajukanJadwal(Request $request)
{
    // 1. Ambil ID Ibu Hamil yang sedang login
    $userId = auth()->id();

    // 2. Cari data pendaftaran terakhir milik user ini di tb_pendaftaran
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', $userId) // <--- Sesuaikan 'user_id' jika nama kolom di tabel Anda berbeda (misal: 'pasien_id')
        ->latest()
        ->first();

    // 3. Proses Logika Percabangan (Update atau Insert)
    if ($pendaftaran) {
        // JIKA SUDAH ADA DATA: Cukup update status_konsultasi menjadi 'menunggu'
        DB::table('tb_pendaftaran')
            ->where('id', $pendaftaran->id)
            ->update([
                'status_konsultasi' => 'menunggu',
                'updated_at' => Carbon::now()
            ]);
    } else {
        // JIKA BELUM ADA DATA: Buat baris baru di tb_pendaftaran
        DB::table('tb_pendaftaran')->insert([
            'user_id' => $userId,
            'status_konsultasi' => 'menunggu',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    // 4. Kembalikan user ke halaman sebelumnya dengan membawa alert sukses
    return redirect()->back()->with('success', 'Pendaftaran Konsultasi Offline Bunda berhasil diajukan!');
    }
}