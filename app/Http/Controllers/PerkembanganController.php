<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan; 

class PerkembanganController extends Controller
{
    public function storePerkembangan(Request $request)
    {
       $request->validate([
    'pasien_id'           => 'required',
    'tanggal_pemeriksaan' => 'required|date',
    'waktu_pemeriksaan'   => 'required',
    'usia_kehamilan'      => 'required|string',
    'trimester'           => 'required|numeric', 
    'kehamilan_ke'        => 'required|numeric', 
    'hpht'                => 'required|date',
    'hpl'                 => 'required|date',
    'berat_badan'         => 'required|numeric',
    'tinggi_badan'        => 'required|numeric',
    'tekanan_darah'       => 'required|string',
    'riwayat_penyakit'    => 'required|string',
    'riwayat_alergi'      => 'required|string',
    'imt'                 => 'required|numeric',
    'lila'                => 'required|numeric',
    'tinggi_fundus'       => 'required|numeric',
    'djj'                 => 'required|numeric',
    'keluhan'             => 'required|string',
    'tindakan'            => 'required|string',
    'obat'                => 'required|string',
]);

        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
    }
}