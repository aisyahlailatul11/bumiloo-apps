<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidanController extends Controller
{
    // 1. Dashboard Utama Bidan
    public function index()
    {
        // Mengarahkan ke file dashboardBidan.blade.php di folder resources/views/bidan/
        return view('bidan.dashboardBidan');
    }

    // 2. Halaman Profil (Siti Fatimah)
    public function profil()
    {
        // Kita ambil data pertama (karena praktik mandiri biasanya hanya ada 1 bidan)
        $bidan = Bidan::first(); 
        
        // Pastikan view mengarah ke tempat yang benar
        // Jika file kamu ada di resources/views/bidan/profil.blade.php:
        return view('bidan.profil', compact('bidan'));
    }

    // 3. Update Data Bidan
    public function update(Request $request, $id)
    {
        $bidan = Bidan::findOrFail($id);
        
        // Validasi simpel agar data aman
        $request->validate([
            'nama_bidan' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except(['_token', '_method']);
        
        // Logika upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images'), $nama_file);
            $data['foto'] = $nama_file;
        }

        $bidan->update($data);

        return redirect()->route('bidan.profil')->with('success', 'Profil Bidan berhasil diperbarui!');
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
}