<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan Carbon di-import di atas jika diperlukan

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
    // Tampilkan Form Perkembangan
    // ================================
    public function indexPerkembangan(Request $request)
{
    // Mengambil pasien_id dari parameter url atau form sebelumnya
    $pasien_id = $request->get('pasien_id') ?? $request->route('pasien_id');
    
    // BACKUP: Jika di URL tidak ada ?pasien_id=2, kita ambil dari Referer URL halaman sebelumnya secara otomatis
    if (!$pasien_id && $request->headers->get('referer')) {
        $referer = $request->headers->get('referer');
        $segments = explode('/', trim(parse_url($referer, PHP_URL_PATH), '/'));
        $pasien_id = end($segments); // Mengambil angka paling ujung (contohnya: 2)
    }

    if (!$pasien_id || !is_numeric($pasien_id)) {
        return redirect()->route('bidan.daftarPasien')->with('error', 'ID Pasien tidak valid.');
    }

    // 1. Cari data pasien
    $pasien = Pasien::findOrFail($pasien_id);

    // 2. Ambil HPHT dari tabel pendaftaran berdasarkan kesamaan NIK
    $pendaftaran = DB::table('pasien')
        ->join('tb_pendaftaran', 'pasien.nik', '=', 'tb_pendaftaran.nik')
        ->where('pasien.id', $pasien_id)
        ->select('tb_pendaftaran.hpht')
        ->first();

    $hpht = $pendaftaran ? $pendaftaran->hpht : null;

    // 3. Kalau pasien sudah pernah periksa, ambil HPHT terbaru dari tabel perkembangan
    $perkembanganTerakhir = Perkembangan::where('pasien_id', $pasien_id)->latest()->first();
    if ($perkembanganTerakhir && $perkembanganTerakhir->hpht) {
        $hpht = $perkembanganTerakhir->hpht;
    }

    // 4. Ubah format tanggal ke Y-m-d agar terbaca oleh <input type="date">
    if ($hpht) {
        $hpht = \Carbon\Carbon::parse($hpht)->format('Y-m-d');
    }

    // Kirim data ke view
    return view('bidan.inputPerkembanganPasien', compact('pasien', 'hpht'));
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
            'hpht'                => 'required|date',
            'hpl'                 => 'required|date',
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
}