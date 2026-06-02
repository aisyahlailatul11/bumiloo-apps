<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi; // Ganti dari Artikel ke Edukasi
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    //TAMPILAN SISI IBU HAMIL (DENGAN FILTER)
    public function index(Request $request)
    {
        $query = Edukasi::query();

        // Pencarian
        if ($request->filled('search')) {
            $query->where('judul_edukasi', 'LIKE', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $artikels = $query->latest()->paginate(6)->withQueryString();
        $populer = Edukasi::latest()->take(3)->get();
        
        // Ambil daftar kategori untuk dropdown
        $kategoris = Edukasi::whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('bumil.beranda', compact('artikels', 'populer', 'kategoris'));
    }

    // TAMPILAN SISI ADMIN
    public function adminIndex()
    {
        $artikels = Edukasi::latest()->get(); 
        return view('admin.edukasi.daftarEdukasi', compact('artikels'));
    }

    public function create()
    {
        return view('admin.edukasi.inputEdukasi');
    }

    public function artikel(Request $request)
{
    // Menggunakan model Edukasi
    $query = \App\Models\Edukasi::query();

    //Logika Pencarian (Judul atau Konten)
    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('judul_edukasi', 'LIKE', $searchTerm)
              ->orWhere('konten_edukasi', 'LIKE', $searchTerm);
        });
    }

    // Mengambil data dengan pagination
    $artikels = $query->latest()->paginate(6)->withQueryString();

    // Kirim hanya data $artikels ke view
    return view('bumil.artikel', compact('artikels'));
}

    //PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'judul_edukasi'   => 'required|string|max:255',
            'kategori'        => 'required|string|max:100',
            'konten_edukasi'  => 'required|string',
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $imageName = $request->file('gambar')->store('artikel-images', 'public');
        }

        Edukasi::create([
            'judul_edukasi'  => $request->judul_edukasi,
            'kategori'       => $request->kategori,
            'konten_edukasi' => $request->konten_edukasi,
            'gambar'         => $imageName,
        ]);

        return redirect()->route('admin.edukasi')->with('success', 'Artikel berhasil ditambahkan!');
    }

    //EDIT
    public function edit($id)
    {
        $artikel = Edukasi::findOrFail($id);
        return view('admin.edukasi.editEdukasi', compact('artikel'));
    }

    //UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_edukasi'   => 'required|string|max:255',
            'kategori'        => 'required|string|max:100',
            'konten_edukasi'  => 'required|string',
        ]);

        $artikel = Edukasi::findOrFail($id);
        $imageName = $artikel->gambar;

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar && !str_contains($artikel->gambar, 'build/images/')) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $imageName = $request->file('gambar')->store('artikel-images', 'public');
        }

        $artikel->update([
            'judul_edukasi'  => $request->judul_edukasi,
            'kategori'       => $request->kategori,
            'konten_edukasi' => $request->konten_edukasi,
            'gambar'         => $imageName,
        ]);

        return redirect()->route('admin.edukasi')->with('success', 'Data berhasil diupdate!');
    }

    // 4. HAPUS
    public function destroy($id)
    {
        $artikel = Edukasi::findOrFail($id);
        if ($artikel->gambar && !str_contains($artikel->gambar, 'build/images/')) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        $artikel->delete();

        return redirect()->route('admin.edukasi')->with('success', 'Artikel berhasil dihapus!');
    }
}