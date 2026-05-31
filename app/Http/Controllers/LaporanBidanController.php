<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use Carbon\Carbon;

class LaporanBidanController extends Controller
{
    public function index()
    {
        // Ambil bulan dan tahun saat ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // DIUBAH: Jumlah kunjungan bulan ini
        $jumlahKunjunganBulanIni = Perkembangan::whereMonth('tanggal_pemeriksaan', $bulanIni)
            ->whereYear('tanggal_pemeriksaan', $tahunIni)
            ->count();

        // DIUBAH: Jumlah persalinan bulan ini
        $jumlahPersalinanBulanIni = Perkembangan::whereMonth('tanggal_pemeriksaan', $bulanIni)
            ->whereYear('tanggal_pemeriksaan', $tahunIni)
            ->where('jenis_layanan', 'Persalinan')
            ->count();

        // Data untuk pie chart (jumlah ibu hamil per trimester)
        $perTrimester = [
            Perkembangan::where('trimester', 1)->count(),
            Perkembangan::where('trimester', 2)->count(),
            Perkembangan::where('trimester', 3)->count(),
        ];

        // Data untuk line chart kunjungan per bulan (tahun berjalan)
        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulan[] = Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
                ->whereYear('tanggal_pemeriksaan', $tahunIni) // Filter berdasarkan tahun ini agar data tahun lalu tidak bercampur
                ->count();
        }

        // Data untuk line chart persalinan per bulan (tahun berjalan)
        $perBulanPersalinan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulanPersalinan[] = Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
                ->whereYear('tanggal_pemeriksaan', $tahunIni) // Filter berdasarkan tahun ini agar data tahun lalu tidak bercampur
                ->where('jenis_layanan', 'Persalinan')
                ->count();
        }

        // Kirim variabel baru ke view
        return view('bidan.laporan', compact(
            'jumlahKunjunganBulanIni',
            'jumlahPersalinanBulanIni',
            'perTrimester',
            'perBulan',
            'perBulanPersalinan'
        ));
    }
}