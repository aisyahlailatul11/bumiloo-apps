<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Perkembangan;
use Illuminate\Support\Facades\Auth;

class BumilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah sudah ada di tabel pendaftaran
        $isRegistered = Pendaftaran::where('user_id', $user->id)->exists();

        if (!$isRegistered) {
            return redirect()->route('pendaftaran.create')
                             ->with('info', 'Silakan lengkapi pendaftaran terlebih dahulu.');
        }

        return view('bumil.dashboard'); 
    }

    public function riwayatPerkembangan()
{
    $user = Auth::user();

    $riwayats = Perkembangan::where('pasien_id', $user->id)
        ->orderBy('tanggal_pemeriksaan', 'desc')
        ->get();

    $terakhir = $riwayats->first();

    return view('bumil.riwayatPerkembangan', compact('riwayats', 'terakhir'));
}

public function detailRiwayatPerkembangan($id)
{
    $user = Auth::user();

    $riwayat = Perkembangan::where('id', $id)
        ->where('pasien_id', $user->id)
        ->firstOrFail();

    return view('bumil.detailRiwayatPerkembangan', compact('riwayat'));
}
public function hpl()
{
    return view('bumil.hpl');
}

    
}