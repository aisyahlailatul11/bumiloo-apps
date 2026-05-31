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