<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;

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
    // cari pasien
    $pasien = Pasien::findOrFail($pasien_id);

    // join pasien dengan tb_pendaftaran berdasarkan nik
    $pendaftaran = DB::table('pasien')
        ->join('tb_pendaftaran', 'pasien.nik', '=', 'tb_pendaftaran.nik')
        ->where('pasien.id', $pasien_id)
        ->select('tb_pendaftaran.hpht')
        ->first();

    // ambil hpht dari hasil join
    $hpht = $pendaftaran ? $pendaftaran->hpht : null;
    // kalau pasien sudah pernah periksa, ambil hpht terbaru dari perkembangan
    $perkembanganTerakhir = Perkembangan::where('pasien_id', $pasien_id)->latest()->first();
    if ($perkembanganTerakhir && $perkembanganTerakhir->hpht) {
        $hpht = $perkembanganTerakhir->hpht;
    }

    return view('bidan.inputPerkembanganPasien', compact('pasien', 'hpht'));
}
}