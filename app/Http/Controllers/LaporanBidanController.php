<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use Carbon\Carbon;

class LaporanBidanController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Jumlah kunjungan hari ini
        $jumlahKunjunganHariIni = Perkembangan::whereDate('tanggal_pemeriksaan', $hariIni)->count();

        // Jumlah persalinan hari ini
        $jumlahPersalinanHariIni = Perkembangan::whereDate('tanggal_pemeriksaan', $hariIni)
            ->where('jenis_layanan', 'Persalinan')
            ->count();

        // Data untuk pie chart (jumlah ibu hamil per trimester)
        $perTrimester = [
            Perkembangan::where('trimester', 1)->count(),
            Perkembangan::where('trimester', 2)->count(),
            Perkembangan::where('trimester', 3)->count(),
        ];

        // Data untuk line chart kunjungan per bulan
        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulan[] = Perkembangan::whereMonth('tanggal_pemeriksaan', $i)->count();
        }

        // Data untuk line chart persalinan per bulan
        $perBulanPersalinan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulanPersalinan[] = Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
                ->where('jenis_layanan', 'Persalinan')
                ->count();
        }

        return view('bidan.laporan', compact(
            'jumlahKunjunganHariIni',
            'jumlahPersalinanHariIni',
            'perTrimester',
            'perBulan',
            'perBulanPersalinan'
        ));
    }
}
