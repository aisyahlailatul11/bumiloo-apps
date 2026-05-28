<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            
            // 🛠️ VALIDASI PASSWORD
            'password' => [
                'required', 
                'confirmed', 
                \Illuminate\Validation\Rules\Password::min(8)  // Minimal 8 karakter
                    ->mixedCase()                              // Wajib ada Huruf Besar & Kecil
                    ->numbers()                                // Wajib ada Angka
                    ->symbols()                                // Wajib ada Simbol/Karakter Khusus
            ],
            'role' => ['required', 'string'],
            'secret_key' => ['nullable', 'string'],
        ]);

        //LOGIKA KEAMANAN RAHASIA (KODE OTORISASI PETUGAS)
        if (in_array($request->role, ['Admin', 'Bidan'])) {
            $secretKey = "BML-2026"; 
            
            if ($request->secret_key !== $secretKey) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'secret_key' => ['Akses Ditolak! Kode Otorisasi Petugas Tidak Valid.'],
                ]);
            }
        }

        //PROSES PEMBUATAN USER KE DATABASE
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        // Langsung login otomatis setelah berhasil daftar
        Auth::login($user);

        if ($user->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->role === 'Bidan') {
            return redirect()->route('bidan.dashboard');
        } 
        
        if ($user->role === 'Ibu Hamil') {
            // Ini yang akan mengirim pesan sukses ke halaman pendaftaran
            return redirect()->route('pendaftaran.create')
                             ->with('success_register', 'Akun berhasil dibuat! Silahkan lengkapi data diri ya.');
        }

        // Jika role tidak dikenal, arahkan ke dashboard umum
        return redirect()->route('dashboard');
}
}