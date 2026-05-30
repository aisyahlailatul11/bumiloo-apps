<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonsultasiBumilController extends Controller
{
    /**
     * Fungsi untuk mengajukan jadwal offline
     */
    public function ajukanJadwal(Request $request)
    {
        // 1. Ambil data pendaftaran berdasarkan user yang sedang login
        $pendaftaran = DB::table('tb_pendaftaran')
            ->where('user_id', Auth::id())
            ->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran bumil tidak ditemukan.');
        }

        // 2. Cari data di 'daftar_pasien' berdasarkan NIK dari data pendaftaran
        // (Atau jika di tb_pendaftaran ada id yang langsung nyambung ke daftar_pasien, sesuaikan bagian ini)
        $pasien = DB::table('daftar_pasien')->where('nik', $pendaftaran->nik)->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien di daftar_pasien tidak ditemukan.');
        }

        // 3. Update status_konsultasi menjadi 'menunggu'
        DB::table('daftar_pasien')
            ->where('id', $pasien->id)
            ->update([
                'status_konsultasi' => 'menunggu'
            ]);

        return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan. Silakan tunggu konfirmasi bidan.');
    }
}