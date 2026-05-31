<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
    $subject = $this->isUpdate ? 'Pemberitahuan Perubahan Jadwal' : 'Jadwal Pemeriksaan Kehamilan';
    
    return $this->subject($subject)
                ->view('emails.jadwal_kontrol');
}

    public function content(): Content
{
    return new Content(
        // Sesuaikan dengan folder yang kamu buat tadi:
        view: 'admin.jadwal.emails.jadwalKontrol', 
    );
}
}