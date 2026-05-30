<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidan extends Model
{
    protected $table = 'bidans';
    // WAJIB ADA INI AGAR BISA DIUPDATE
    protected $fillable = ['nama', 'nip', 'sip', 'email', 'profil_singkat', 'no_hp', 'alamat_praktik', 'status', 'jadwal_praktik', 'detail_tambahan', 'foto'];
}