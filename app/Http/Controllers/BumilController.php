<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
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
}