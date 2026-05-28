<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 1. Amankan jika role kosong
        if (empty($user->role)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/login')->with('error', 'Akun Anda belum memiliki role akses');
        }

        // 2. Redirect berdasarkan role dengan Alert
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
        }

        if ($user->role === 'Bidan') {
            return redirect()->route('bidan.dashboard')->with('success', 'Selamat datang Bu Bidan!');
        }

        if ($user->role === 'Bumil') {
            $sudahDaftar = DB::table('tb_pendaftaran')
                ->where('user_id', $user->id)
                ->exists();

            if ($sudahDaftar) {
                session()->flash('success', 'Halo Bunda, selamat datang kembali!');
                return redirect()->route('bumil.dashboard');
            } else {
                session()->flash('info', 'Silakan lengkapi data pendaftaran.');
                return redirect()->route('pendaftaran.create');
            }
        } // <--- KURUNG INI TADI KURANG!

        return redirect()->route('login')->with('error', 'Role tidak dikenali.');
    }

    /**
     * Destroy an authenticated session (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke login agar user benar-benar keluar dari area dashboard Bumiloo
        return redirect('/login');
    }
}