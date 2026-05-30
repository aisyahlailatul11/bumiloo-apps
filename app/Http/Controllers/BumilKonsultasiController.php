<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonsultasiBumilController extends Controller
{
    /**
     * Fungsi untuk mengajukan jadwal offline (mengubah status_konsultasi menjadi 'menunggu')
     */
    public function ajukanJadwal(Request $request)
    {
        // 1. Ambil ID pengguna/pasien yang sedang login
        $userId = Auth::id(); 

        // 2. Cari data pasien di tabel 'daftar_pasien' berdasarkan user_id / id yang login
        // Catatan: Jika relasi login kamu menggunakan ID lain, sesuaikan where-nya ya.
        $pasien = DB::table('daftar_pasien')->where('id', $userId)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        // 3. Update status_konsultasi menjadi 'menunggu'
        DB::table('daftar_pasien')
            ->where('id', $pasien->id)
            ->update([
                'status_konsultasi' => 'menunggu'
            ]);

        // 4. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan. Silakan tunggu konfirmasi bidan.');
    }
}