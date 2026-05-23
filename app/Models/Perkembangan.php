<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    protected $table = 'perkembangan';

    protected $fillable = [
        'pasien_id',
        'tanggal_pemeriksaan',
        'waktu_pemeriksaan',
        'usia_kehamilan',
        'trimester',
        'kehamilan_ke',
        'riwayat_penyakit',
        'riwayat_alergi',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'tekanan_darah',
        'tinggi_fundus',
        'lila',
        'djj',
        'keluhan',
        'tindakan',
        'obat',
        'catatan_tambahan'
    ];
}
