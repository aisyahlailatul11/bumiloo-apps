<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware; // Harus ada
use Illuminate\Routing\Controllers\Middleware;    // Harus ada

class BumilController extends Controller implements HasMiddleware // WAJIB ada "implements HasMiddleware"
{
    /**
     * Menampilkan dashboard khusus ibu hamil
     */
    public static function middleware(): array
    {
        return [
            'auth', // Middleware auth dijalankan di sini
        ];
    }

    public function index()
{
    $user = auth()->user();

    // 1. Arahkan Admin & Bidan ke dashboard mereka masing-masing
    if ($user->role === 'Admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'Bidan') return redirect()->route('bidan.dashboard');

    // 2. Jika Bumil, cari data pendaftaran
    // Kita cek dulu berdasarkan user_id (Online), jika tidak ada, baru berdasarkan NIK (Offline)
    $data = DB::table('tb_pendaftaran')
                ->where('user_id', $user->id)
                ->first();

    // 3. Jika belum ketemu via user_id, cari via NIK 
    // (Penting: Pastikan tabel 'users' punya kolom 'nik')
    if (!$data && !empty($user->nik)) {
        $data = DB::table('tb_pendaftaran')
                    ->where('nik', $user->nik)
                    ->first();
        
        // Opsional: Jika ketemu via NIK, kita bisa otomatis isi user_id-nya 
        // agar ke depannya sistem lebih cepat mencarinya
        if ($data) {
            DB::table('tb_pendaftaran')
                ->where('id', $data->id)
                ->update(['user_id' => $user->id]);
        }
    }

    // 4. Jika tetap tidak ada data sama sekali, baru paksa ke pendaftaran
    if (!$data) {
        return redirect()->route('pendaftaran.create')
                         ->with('info', 'Silakan lengkapi formulir pendaftaran.');
    }

    // 5. Tampilkan dashboard
    return view('bumil.dashboard', compact('data'));
}

   public function konsultasi()
{
    $pesans = DB::table('konsultasis')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'asc')
        ->get();

    return view('bumil.konsultasi', compact('pesans'));
}

public function kirimKonsultasi(Request $request)
{
    $request->validate([
        'pesan' => 'required'
    ]);

    DB::table('konsultasis')->insert([
        'user_id' => Auth::id(),
        'bidan_id' => null,
        'pesan' => $request->pesan,
        'sender' => 'bumil',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('bumil.konsultasi');
}
    public function riwayatPerkembangan()
{
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', Auth::id())
        ->first();

    if (!$pendaftaran) {
        return back()->with('error', 'Data bumil tidak ditemukan.');
    }

    $riwayats = DB::table('perkembangan')
        ->where('pasien_id', $pendaftaran->id)
        ->orderBy('tanggal_pemeriksaan', 'desc')
        ->get();

    $terakhir = $riwayats->first();

    return view('bumil.riwayatPerkembangan', compact(
        'pendaftaran',
        'riwayats',
        'terakhir'
    ));
}
public function detailRiwayatPerkembangan($id)
{
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', Auth::id())
        ->first();

    $riwayat = DB::table('perkembangan')
        ->where('id', $id)
        ->where('pasien_id', $pendaftaran->id)
        ->first();

    if (!$riwayat) {
        abort(404);
    }

    return view('bumil.detailRiwayatPerkembangan', compact(
        'riwayat',
        'pendaftaran'
    ));
}
    public function hpl()
    {
        return view('bumil.hpl');
    }
    public function reminder()
{
    $data = DB::table('tb_pendaftaran')
        ->where('user_id', Auth::id())
        ->first();

    if ($data) {
        $jadwals = DB::table('jadwals')
            ->where('nik', $data->nik)
            ->orderBy('tgl_pemeriksaan', 'asc')
            ->orderBy('jam', 'asc')
            ->get();
    } else {
        $jadwals = collect();
    }

    $events = $jadwals->map(function ($jadwal) {
        return [
            'title' => $jadwal->keterangan ?? 'Jadwal Konsultasi',
            'start' => $jadwal->tgl_pemeriksaan . 'T' . $jadwal->jam,
            'extendedProps' => [
                'jam' => $jadwal->jam,
                'keterangan' => $jadwal->keterangan ?? 'Jadwal Konsultasi',
            ],
        ];
    });

    return view('bumil.reminder', compact('data', 'jadwals', 'events'));
}
}