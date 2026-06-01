<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidanController extends Controller
{

public function index()
{
    $janjiHariIni = DB::table('jadwals')
        ->whereDate('tgl_pemeriksaan', today())
        ->count();

    $pemeriksaanBulanIni = DB::table('perkembangan')
        ->whereMonth('tanggal_pemeriksaan', now()->month)
        ->whereYear('tanggal_pemeriksaan', now()->year)
        ->count();

    $totalPasien = DB::table('users')
        ->where('role', 'bumil')
        ->count();

    $rataKunjungan = $totalPasien > 0
        ? round($pemeriksaanBulanIni / $totalPasien, 2)
        : 0;

    $jadwalHariIni = DB::table('jadwals')
        ->whereDate('tgl_pemeriksaan', today())
        ->orderBy('jam', 'asc')
        ->get();

    $trimester = DB::table('perkembangan')
        ->select('trimester', DB::raw('COUNT(DISTINCT pasien_id) as total'))
        ->groupBy('trimester')
        ->pluck('total', 'trimester');

    $kunjunganBulanan = DB::table('perkembangan')
        ->selectRaw('MONTH(tanggal_pemeriksaan) as bulan, COUNT(*) as total')
        ->whereYear('tanggal_pemeriksaan', now()->year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $perTrimester = [
        $trimester[1] ?? 0,
        $trimester[2] ?? 0,
        $trimester[3] ?? 0,
    ];

    $perBulan = [];
    for ($i = 1; $i <= 12; $i++) {
        $perBulan[] = $kunjunganBulanan[$i] ?? 0;
    }

    return view('bidan.dashboardBidan', compact(
        'janjiHariIni',
        'pemeriksaanBulanIni',
        'rataKunjungan',
        'jadwalHariIni',
        'trimester',
        'kunjunganBulanan',
        'perTrimester',
        'perBulan'
    ));
}
public function konsultasi()
{
    $konsultasis = DB::table('konsultasis')
        ->join('users', 'konsultasis.user_id', '=', 'users.id')
        ->select(
            'konsultasis.user_id',
            'users.name as nama_pasien',
            DB::raw('MAX(konsultasis.created_at) as waktu_terakhir')
        )
        ->groupBy('konsultasis.user_id', 'users.name')
        ->orderBy('waktu_terakhir', 'desc')
        ->get();

    return view('bidan.konsultasi', compact('konsultasis'));
}

public function detailKonsultasi($user_id)
{
    $konsultasis = DB::table('konsultasis')
        ->join('users', 'konsultasis.user_id', '=', 'users.id')
        ->select(
            'konsultasis.user_id',
            'users.name as nama_pasien',
            DB::raw('MAX(konsultasis.created_at) as waktu_terakhir')
        )
        ->groupBy('konsultasis.user_id', 'users.name')
        ->orderBy('waktu_terakhir', 'desc')
        ->get();

    $pasien = DB::table('users')
        ->where('id', $user_id)
        ->first();

    $pesans = DB::table('konsultasis')
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'asc')
        ->get();

    return view('bidan.detailKonsultasi', compact(
        'konsultasis',
        'pasien',
        'pesans',
        'user_id'
    ));
}

public function kirimKonsultasi(Request $request, $user_id)
{
    $request->validate([
        'pesan' => 'required'
    ]);

    DB::table('konsultasis')->insert([
        'user_id' => $user_id,
        'bidan_id' => Auth::id(),
        'pesan' => $request->pesan,
        'sender' => 'bidan',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('bidan.konsultasi.detail', $user_id);
}
// BidanController.php
public function cekKunjunganPasien($pasien_id)
{
    $sudahAda = \App\Models\Perkembangan::where('pasien_id', $pasien_id)->exists();
    
    return response()->json([
        'sudah_ada' => $sudahAda
    ]);
}
public function requestOffline($user_id)
{
    DB::table('konsultasis')->insert([
        'user_id' => $user_id,
        'bidan_id' => Auth::id(),
        'pesan' => 'Bunda disarankan untuk melakukan konsultasi offline/pemeriksaan langsung. Silakan klik tombol Ajukan Jadwal Offline untuk mengajukan jadwal.',
        'sender' => 'bidan',
        'tipe_pesan' => 'request_offline',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Pesan request konsultasi offline berhasil dikirim.');
}
}