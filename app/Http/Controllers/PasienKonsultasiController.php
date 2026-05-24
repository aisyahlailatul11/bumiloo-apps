<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidanKonsultasiController extends Controller
{
    /**
     * Menampilkan ruang konsultasi di sisi Ibu Hamil
     */
    public function indexBumil()
    {
        // Mengarah ke file view resources/views/bumil/konsultasi.blade.php
        return view('bumil.konsultasi');
    }
}