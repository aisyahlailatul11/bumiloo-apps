<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BumilKonsultasiController extends Controller
{
    /**
     * Fungsi untuk mengajukan jadwal offline
     */
    // CONTOH PERBAIKAN DI CONTROLLER
public function ajukanOffline(Request $request) 
{
    $userId = auth()->id();

    // Menggunakan ->first() agar menghasilkan satu data tunggal, BUKAN kumpulan data (Collection)
    $cekPendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->first(); 

    if ($cekPendaftaran) {
        // Jika data ada, langsung update berdasarkan ID uniknya
        DB::table('tb_pendaftaran')
            ->where('id', $cekPendaftaran->id)
            ->update([
                'status_konsultasi' => 'menunggu',
                'updated_at'        => \Carbon\Carbon::now()
            ]);
    } else {
        // Jika belum ada data, buat data baru
        DB::table('tb_pendaftaran')->insert([
            'user_id'           => $userId,
            'status_konsultasi' => 'menunggu',
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()
        ]);
    }

    return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan!');
}
}