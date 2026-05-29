<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use Carbon\Carbon;

class DaftarPasienController extends Controller
{
    public function index()
    {
        // Ambil tanggal hari ini
        $hariIni = Carbon::today();

        // Ambil jadwal pasien untuk hari ini, urutkan berdasarkan jam
        $pasienList = Jadwal::whereDate('tgl_pemeriksaan', $hariIni)
                            ->orderBy('jam', 'asc')
                            ->get();

        // Kirim ke view
        return view('bidan.daftarPasien', compact('pasienList'));
    }
    
    public function editPasien($id)
{
    $pasien = \App\Models\Pendaftaran::findOrFail($id);
    return view('bidan.inputDaftarPasien', compact('pasien'));
}

}
