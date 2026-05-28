<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ================================
    // Halaman Utama Laporan
    // ================================
    public function index(Request $request)
    {
        $data = $this->getFilteredData($request);

        $perTrimester = [
            $data->where('trimester', 1)->count(),
            $data->where('trimester', 2)->count(),
            $data->where('trimester', 3)->count(),
        ];

        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulan[] = $data->filter(function($item) use ($i) {
                return \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->month == $i;
            })->count();
        }

        $perBulanPersalinan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulanPersalinan[] = $data->filter(function($item) use ($i) {
                return \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->month == $i
                    && $item->jenis_layanan == 'Persalinan';
            })->count();
        }

        return view('admin.laporan.laporan', compact('data', 'perTrimester', 'perBulan', 'perBulanPersalinan'));
    }

    // ================================
    // Export PDF
    // ================================
    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredData($request);
        $pdf = Pdf::loadView('admin.laporan.exportPdf', compact('data'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-pemeriksaan.pdf');
    }

    // ================================
    // Export Excel
    // ================================
    public function exportExcel(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanExport($request),
            'laporan-pemeriksaan.xlsx'
        );
    }

    // ================================
    // Method Helper Filter (dipakai ulang)
    // ================================
    private function getFilteredData(Request $request)
    {
        $query = Perkembangan::with('pasien');

        if ($request->tanggal_awal) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $request->tanggal_awal);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $request->tanggal_akhir);
        }
        if ($request->trimester && $request->trimester != 'semua') {
            $query->where('trimester', $request->trimester);
        }
        if ($request->jenis_layanan && $request->jenis_layanan != 'semua') {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->imt && $request->imt != 'semua') {
            $query->where('imt', $request->imt);
        }
        if ($request->usia_min) {
            $query->where('usia_kehamilan', '>=', $request->usia_min);
        }
        if ($request->usia_max) {
            $query->where('usia_kehamilan', '<=', $request->usia_max);
        }
        if ($request->nama_pasien) {
            $query->whereHas('pasien', fn($q) => 
                $q->where('nama_pasien', 'like', '%'.$request->nama_pasien.'%')
            );
        }

        return $query->get();
    }
}