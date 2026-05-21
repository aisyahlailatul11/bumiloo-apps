<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan; // Memanggil Model Perkembangan yang baru dibuat

class PerkembanganController extends Controller
{
    // Memproses simpan data dari form perkembangan pasien
    public function storePerkembangan(Request $request)
    {
        // 1. Validasi Server (Kunci ganda jika Javascript browser dimatikan)
       $request->validate([
    'pasien_id'           => 'required',
    'tanggal_pemeriksaan' => 'required|date',
    'waktu_pemeriksaan'   => 'required',
    'usia_kehamilan'      => 'required|string',
    'trimester'           => 'required|numeric', // Baru
    'kehamilan_ke'        => 'required|numeric', // Baru
    'hpht'                => 'required|date',
    'hpl'                 => 'required|date',
    'berat_badan'         => 'required|numeric',
    'tinggi_badan'        => 'required|numeric',
    'tekanan_darah'       => 'required|string',
    // Kolom-kolom di bawah ini dibuat opsional/boleh kosong di validasi laravel
    'riwayat_penyakit'    => 'nullable|string',
    'riwayat_alergi'      => 'nullable|string',
    'imt'                 => 'nullable|numeric',
    'lila'                => 'nullable|numeric',
    'tinggi_fundus'       => 'nullable|numeric',
    'djj'                 => 'nullable|numeric',
    'keluhan'             => 'required|string',
    'tindakan'            => 'required|string',
    'obat'                => 'required|string',
]);

        // 3. Kembali ke halaman form dengan membawa flash session alert sukses
        return redirect()->back()->with('success', 'Data Perkembangan Medis Berhasil Ditambahkan!');
    }
}