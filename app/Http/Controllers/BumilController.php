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
}