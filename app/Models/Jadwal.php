<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // Tambahkan baris ini agar tidak error saat Simpan
    protected $fillable = [
    'pendaftaran_id', // WAJIB ada
    'nama_pasien', 'nik', 'no_hp', 'tgl_lahir', 
    'tgl_pemeriksaan', 'jam', 'keterangan'
];

public function user()
{
    // Hubungkan Jadwal ke Pendaftaran dulu lewat NIK
    // Lalu dari Pendaftaran baru ke User
    return $this->hasOne(\App\Models\Pendaftaran::class, 'nik', 'nik')
                ->latest(); // ambil pendaftaran terakhir
}

public function pendaftaran() {
    return $this->belongsTo(\App\Models\Pendaftaran::class, 'pendaftaran_id');
}
}