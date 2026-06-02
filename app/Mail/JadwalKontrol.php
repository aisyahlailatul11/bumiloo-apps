<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalKontrol extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal; 
    public $isUpdate;

    public function __construct($jadwal, $isUpdate = false)
    {
        $this->jadwal = $jadwal;
        $this->isUpdate = $isUpdate;
    }

    public function build()
    {
        // Tentukan subject berdasarkan kondisi update
        $subject = $this->isUpdate ? 'Pemberitahuan Perubahan Jadwal' : 'Jadwal Pemeriksaan Kehamilan';
        
        return $this->subject($subject)
                    ->view('admin.jadwal.emails.jadwalKontrol'); // Pastikan path view ini benar
    }
}