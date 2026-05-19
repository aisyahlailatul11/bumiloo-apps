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

        // 1. Amankan jika role kosong di database agar tidak error kosong polos
        if (empty($user->role)) {
            // Paksa logout jika akun tidak punya role jelas
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/login')->withErrors([
                'email' => 'Akun Anda belum memiliki role akses. Silakan hubungi IT Admin.',
            ]);
        }

        // 2. Redirect kaku berdasarkan role (Menghindari nyangkut di kamar role lain)
        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard'); 
        }

        if ($user->role === 'Bidan') {
            return redirect()->route('bidan.dashboard');
        }

        if ($user->role === 'Bumil') {
            $sudahDaftar = DB::table('tb_pendaftaran')
                ->where('user_id', $user->id)
                ->exists();

            return $sudahDaftar 
                ? redirect()->route('bumil.dashboard') 
                : redirect()->route('pendaftaran.create');
        }

        return redirect('/');
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