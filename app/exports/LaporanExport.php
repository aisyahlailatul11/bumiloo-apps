<?php

namespace App\Exports;

use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Perkembangan::with('pasien');

        if ($this->request->tanggal_awal) {
            $query->whereDate('tanggal_pemeriksaan', '>=', $this->request->tanggal_awal);
        }
        if ($this->request->tanggal_akhir) {
            $query->whereDate('tanggal_pemeriksaan', '<=', $this->request->tanggal_akhir);
        }
        if ($this->request->trimester && $this->request->trimester != 'semua') {
            $query->where('trimester', $this->request->trimester);
        }
        if ($this->request->jenis_layanan && $this->request->jenis_layanan != 'semua') {
            $query->where('jenis_layanan', $this->request->jenis_layanan);
        }
        if ($this->request->nama_pasien) {
            $query->whereHas('pasien', fn($q) =>
                $q->where('nama_pasien', 'like', '%'.$this->request->nama_pasien.'%')
            );
        }

        return $query->get()->map(function($row) {
            return [
                'ID Pasien'           => $row->pasien_id,
                'Nama'                => $row->pasien->nama_pasien ?? '-',
                'Tgl Pemeriksaan'     => $row->tanggal_pemeriksaan,
                'Waktu'               => $row->waktu_pemeriksaan,
                'Usia Kehamilan'      => $row->usia_kehamilan,
                'Trimester'           => $row->trimester,
                'Kehamilan Ke'        => $row->kehamilan_ke,
                'Jenis Layanan'       => $row->jenis_layanan,
                'Berat Badan'         => $row->berat_badan,
                'Tinggi Badan'        => $row->tinggi_badan,
                'IMT'                 => $row->imt,
                'Tekanan Darah'       => $row->tekanan_darah,
                'Tinggi Fundus'       => $row->tinggi_fundus,
                'LILA'                => $row->lila,
                'DJJ'                 => $row->djj,
                'Riwayat Penyakit'    => $row->riwayat_penyakit,
                'Riwayat Alergi'      => $row->riwayat_alergi,
                'Keluhan'             => $row->keluhan,
                'Tindakan'            => $row->tindakan,
                'Obat'                => $row->obat,
                'Catatan Tambahan'    => $row->catatan_tambahan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Pasien', 'Nama', 'Tgl Pemeriksaan', 'Waktu',
            'Usia Kehamilan', 'Trimester', 'Kehamilan Ke', 'Jenis Layanan',
            'Berat Badan', 'Tinggi Badan', 'IMT', 'Tekanan Darah',
            'Tinggi Fundus', 'LILA', 'DJJ', 'Riwayat Penyakit',
            'Riwayat Alergi', 'Keluhan', 'Tindakan', 'Obat', 'Catatan Tambahan'
        ];
    }
}