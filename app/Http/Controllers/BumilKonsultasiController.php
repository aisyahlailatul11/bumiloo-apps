<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BumilKonsultasiController extends Controller
{
    /**
     * Fungsi untuk mengajukan jadwal offline
     */
    public function ajukanJadwal(Request $request)
{
    $userId = Auth::id();

    // 1. Ambil data pendaftaran terakhir milik user ini
    $pendaftaran = DB::table('tb_pendaftaran')
        ->where('user_id', $userId)
        ->latest()
        ->first();

    // 2. Update status_konsultasi HANYA di tb_pendaftaran
    if ($pendaftaran) {
        DB::table('tb_pendaftaran')
            ->where('id', $pendaftaran->id)
            ->update([
                'status_konsultasi' => 'menunggu',
                'updated_at' => Carbon::now()
            ]);
    } else {
        DB::table('tb_pendaftaran')->insert([
            'user_id' => $userId,
            'status_konsultasi' => 'menunggu',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    // 3. Ambil data pesan terakhir dari bidan
    $pesanBidan = DB::table('konsultasis')
        ->where('user_id', $userId)
        ->where('sender', 'bidan')
        ->where('tipe_pesan', 'request_offline')
        ->orderBy('id', 'desc')
        ->first();

    $bidanId = $pesanBidan ? $pesanBidan->bidan_id : null;

    // 4. Tambahkan pesan ke tabel 'konsultasis'
    DB::table('konsultasis')->insert([
        'user_id'    => $userId,
        'bidan_id'   => $bidanId,
        'pesan'      => 'Bunda menyetujui pengajuan konsultasi offline dan sedang menunggu konfirmasi jadwal dari Bidan.',
        'sender'     => 'bumil',
        'tipe_pesan' => 'text',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 5. BLOK KODE UNTUK TABEL 'pasien' SUDAH DIHAPUS 
    // karena status_konsultasi hanya ada di tb_pendaftaran.

    return redirect()->back()->with('success', 'Jadwal offline berhasil diajukan!');
}
}