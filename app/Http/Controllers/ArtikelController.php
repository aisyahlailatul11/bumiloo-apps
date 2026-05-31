<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // 1. TAMPILAN SISI IBU HAMIL (BUMIL)
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('artikel', compact('artikels'));
    }

    // 2. TAMPILAN SISI ADMIN (Halaman "Daftar Edukasi" di foto kamu)
    public function adminIndex()
    {
        $artikels = Artikel::orderBy('id', 'desc')->get();
        // Sesuaikan dengan nama file blade admin kamu, contoh: 'admin.edukasi'
        return view('admin.edukasi.inputEdukasi', compact('artikels'));
    }

    // 3. PROSES SIMPAN ARTIKEL BARU DARI ADMIN
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $gambarPath = $request->file('gambar')->store('artikel-images', 'public');

        Artikel::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->back()->with('success', 'Artikel edukasi berhasil ditambahkan!');
    }

    // 4. PROSES HAPUS ARTIKEL (Untuk tombol "Hapus" merah di foto kamu)
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return redirect()->back()->with('success', 'Artikel berhasil dihapus!');
    }
}