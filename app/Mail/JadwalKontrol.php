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

    public $jadwal; // Variabel ini untuk menampung data jadwal

    public function __construct($jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jadwal Kontrol Kehamilan - Bumiloo',
        );
    }

    public function content(): Content
{
    return new Content(
        // Sesuaikan dengan folder yang kamu buat tadi:
        view: 'admin.jadwal.emails.jadwalKontrol', 
    );
}
}