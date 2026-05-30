<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;

class PerkembanganController extends Controller
{
    // ================================
    // Cek Riwayat Kunjungan Pasien
    // ================================
    public function cekKunjungan($pasien_id)
    {
        $total = Perkembangan::where('pasien_id', $pasien_id)->count();
        return response()->json(['total_kunjungan' => $total]);
    }

    // ================================
    // Simpan Data Perkembangan
    // ================================
    public function storePerkembangan(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id'           => 'required',
            'tanggal_pemeriksaan' => 'required|date',
            'waktu_pemeriksaan'   => 'required',
            'usia_kehamilan'      => 'required|string',
            'trimester'           => 'required|numeric|in:1,2,3',
            'kehamilan_ke'        => 'required|numeric',
            'berat_badan'         => 'required|numeric',
            'tinggi_badan'        => 'required|numeric',
            'tekanan_darah'       => 'required|string',
            'riwayat_penyakit'    => 'required|string',
            'riwayat_alergi'      => 'required|string',
            'imt'                 => 'required|numeric',
            'lila'                => 'required|numeric|between:10,99.99',
            'tinggi_fundus'       => 'required|numeric',
            'djj'                 => 'required|numeric',
            'keluhan'             => 'required|string',
            'tindakan'            => 'required|string',
            'obat'                => 'required|string',
            'catatan_tambahan'    => 'nullable|string',
            'jenis_layanan'       => 'required|string',
        ]);

        Perkembangan::create($validatedData);
        return redirect()->back()->with('success', 'Data pasien berhasil disimpan!');
    }

    public function indexPerkembangan($pasien_id)
    {
        // Mencari data pasien berdasarkan ID, jika tidak ada akan memunculkan error 404
        $pasien = Pasien::findOrFail($pasien_id);

        // Kirim data pasien ke halaman view
        return view('bidan.inputPerkembanganPasien', compact('pasien'));
    }
}