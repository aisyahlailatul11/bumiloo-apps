<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BumilController extends Controller
{
    /**
     * Menampilkan dashboard khusus ibu hamil
     */
    public function index()
    {
        // 1. Ambil data pendaftaran milik user yang sedang login
        $data = DB::table('tb_pendaftaran')
                    ->where('user_id', Auth::id())
                    ->first();

        // 2. Keamanan: Jika user belum daftar, paksa kembali ke form pendaftaran
        if (!$data) {
            return redirect()->route('pendaftaran.create')
                             ->with('info', 'Silakan lengkapi formulir pendaftaran terlebih dahulu.');
        }

        // 3. Tampilkan halaman dashboard dan kirim datanya
        return view('bumil.dashboard', compact('data'));
    }
   public function konsultasi()
{
    $pesans = DB::table('konsultasis')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'asc')
        ->get();

    return view('bumil.konsultasi', compact('pesans'));
}

public function kirimKonsultasi(Request $request)
{
    $request->validate([
        'pesan' => 'required'
    ]);

    DB::table('konsultasis')->insert([
        'user_id' => Auth::id(),
        'bidan_id' => null,
        'pesan' => $request->pesan,
        'sender' => 'bumil',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('bumil.konsultasi');
}
    public function riwayatPerkembangan()
{
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', Auth::id())
        ->first();

    if (!$pendaftaran) {
        return back()->with('error', 'Data bumil tidak ditemukan.');
    }

    $riwayats = DB::table('perkembangan')
        ->where('pasien_id', $pendaftaran->id)
        ->orderBy('tanggal_pemeriksaan', 'desc')
        ->get();

    $terakhir = $riwayats->first();

    return view('bumil.riwayatPerkembangan', compact(
        'pendaftaran',
        'riwayats',
        'terakhir'
    ));
}
public function detailRiwayatPerkembangan($id)
{
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', Auth::id())
        ->first();

    $riwayat = DB::table('perkembangan')
        ->where('id', $id)
        ->where('pasien_id', $pendaftaran->id)
        ->first();

    if (!$riwayat) {
        abort(404);
    }

    return view('bumil.detailRiwayatPerkembangan', compact(
        'riwayat',
        'pendaftaran'
    ));
}
    public function hpl()
    {
        return view('bumil.hpl');
    }
}