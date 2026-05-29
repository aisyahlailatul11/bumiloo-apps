<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    // Update profil (name, email, no_hp)
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'bumil') {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
        }

        $request->validate([
            'nama'  => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name  = $request->nama;
        $user->email = $request->email;
        $user->save();

        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        if ($pendaftaran) {
            $pendaftaran->update([
                'nama'  => $request->nama,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->back()->with('success', 'Data diri berhasil diperbarui!');
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    // Ganti email
    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan.',
        ]);

        $user->update(['email' => $request->email]);

        return back()->with('success', 'Email berhasil diubah!');
    }

    // Hapus akun
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Pendaftaran::where('user_id', $user->id)->delete();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }

    // Halaman keamanan
    public function keamanan()
    {
        $role = auth()->user()->role;
        return view('partials.subsettings.keamanan', compact('role'));
    }

    // Halaman ganti nomor
    public function gantiNomor()
    {
        $role = auth()->user()->role;
        return view('partials.subsettings.gantinomor', compact('role'));
    }

    // Halaman bantuan
    public function bantuan()
    {
        $role = auth()->user()->role;
        return view('partials.subsettings.bantuan', compact('role'));
    }

    // Update avatar
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function updateNoHp(Request $request)
    {
        $request->validate(['no_hp' => 'required|string|max:15']);
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();
        if ($pendaftaran) {
            $pendaftaran->update(['no_hp' => $request->no_hp]);
        }
        return redirect()->back()->with('success', 'Nomor HP berhasil diperbarui!');
    }

    public function index()
    {
        $role = auth()->user()->role;
        return view('pengaturan.index', compact('role'));
    }
}