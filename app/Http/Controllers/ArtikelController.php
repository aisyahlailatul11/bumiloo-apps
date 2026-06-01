<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel; // <--- PASTIKAN BARIS INI ADA AGAR TIDAK ERROR LAGI!
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    // 1. TAMPILAN SISI IBU HAMIL (BUMIL)
    public function index()
    {
        $artikels = Artikel::latest()->get();
        $populer = Artikel::latest()->take(3)->get();

        return view('bumil.beranda', compact('artikels', 'populer'));
    }

    // 2. TAMPILAN SISI ADMIN (Halaman Tabel Daftar Edukasi)
    public function adminIndex()
    {
        $artikels = Artikel::latest()->get();
        
        // Mengarah langsung ke file daftarEdukasi.blade.php kamu
        return view('admin.edukasi.daftarEdukasi', compact('artikels'));
    }

    // 2b. TAMPILAN FORM INPUT (Saat tombol "+ Tambah Edukasi" diklik)
    public function create()
    {
        // Mengarah langsung ke file inputEdukasi.blade.php kamu
        return view('admin.edukasi.inputEdukasi');
    }

// 3. PROSES SIMPAN ARTIKEL BARU DARI ADMIN
    public function store(Request $request)
    {
        // Validasi membaca input dari form blade
        $request->validate([
            'judul_edukasi'   => 'required|string|max:255',
            'kategori'        => 'required|string|max:100',
            'konten_edukasi'  => 'required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('artikel-images', 'public');
            $imageName = $imagePath;
        }

        // PERBAIKAN UTAMA: Mengembalikan nama kolom kiri ke struktur asli database kamu
        \App\Models\Artikel::create([
    'judul_edukasi'  => $request->judul_edukasi,
    'kategori'       => $request->kategori,
    'konten_edukasi' => $request->konten_edukasi,
    'gambar'         => $imageName,
]);

        // Dialihkan kembali ke rute daftar edukasi admin setelah sukses
        return redirect()->route('admin.edukasi')->with('success', 'Artikel edukasi berhasil ditambahkan!');
    }

    // =========================================================================
    // JANGAN UBAH APAPUN DI BAWAH BARIS INI (BIARKAN FUNGSI DESTROY KAMU TETAP DISINI)
    // =========================================================================

    // 4. PROSES HAPUS ARTIKEL (TIDAK DIUBAH SAMA SEKALI)
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->gambar && !str_contains($artikel->gambar, 'build/images/')) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return redirect()->route('admin.edukasi')->with('success', 'Artikel edukasi berhasil dihapus!');
    }
}