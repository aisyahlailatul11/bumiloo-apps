<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidanController extends Controller
{

public function index()
{
    // Ini adalah halaman dashboard bidan
    return view('bidan.dashboardBidan'); 
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