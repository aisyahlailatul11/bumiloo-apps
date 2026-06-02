<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .email-container { font-family: 'Poppins', sans-serif; max-width: 500px; margin: 20px auto; border: 1px solid #fce7f3; border-radius: 20px; overflow: hidden; background-color: #ffffff; }
        .header { background-color: #f472b6; padding: 30px; text-align: center; color: #ffffff; }
        .content { padding: 30px; color: #374151; }
        .details-box { background-color: #fff5f7; padding: 20px; border-radius: 15px; margin: 20px 0; border-left: 5px solid #f472b6; }
        .info-item { margin-bottom: 12px; font-weight: 400; }
        .footer-note { font-size: 0.85em; color: #6b7280; text-align: center; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .btn-calendar { display: block; width: fit-content; margin: 25px auto 0; background: linear-gradient(135deg, #f472b6, #db2777); color: #ffffff !important; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; text-align: center; box-shadow: 0 4px 10px rgba(244, 114, 182, 0.3); }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">{{ $isUpdate ? 'Update Jadwal' : 'Jadwal Baru Bunda!' }}</h1>
        </div>
        
        <div class="content">
            <p style="margin-top:0;">Halo Bunda <b>{{ $jadwal->nama_pasien }}</b>,</p>
            
            @if($isUpdate)
                <p>Kami ingin menginformasikan bahwa telah terjadi <b>perubahan</b> pada jadwal kontrol kehamilan Bunda di <b>BUMILOO</b>. Mohon perhatikan detail terbaru berikut:</p>
            @else
                <p>Senang sekali bisa mendampingi Bunda! Jadwal kontrol kehamilan di <b>BUMILOO</b> telah berhasil dibuat:</p>
            @endif
            
            <div class="details-box">
                <div class="info-item">📅 <b>Tanggal:</b> {{ date('d F Y', strtotime($jadwal->tgl_pemeriksaan)) }}</div>
                <div class="info-item">⏰ <b>Jam:</b> {{ date('H:i', strtotime($jadwal->jam)) }} WIB</div>
                <div class="info-item">📝 <b>Keterangan:</b> {{ $jadwal->keterangan }}</div>
            </div>

            <p>Pastikan Bunda datang tepat waktu agar pemeriksaan berjalan lancar. Semoga Bunda dan si kecil selalu sehat!</p>

            <a href="https://www.google.com/calendar/render?action=TEMPLATE&text=Kontrol+Kehamilan+Bumiloo&details=Kontrol+di+Praktik+Bidan+Mandiri&dates={{ date('Ymd', strtotime($jadwal->tgl_pemeriksaan)) }}T{{ date('Hi', strtotime($jadwal->jam)) }}00Z/{{ date('Ymd', strtotime($jadwal->tgl_pemeriksaan)) }}T{{ date('Hi', strtotime($jadwal->jam) + 3600) }}00Z" 
               class="btn-calendar">📅 Tambah ke Google Calendar</a>

            <div class="footer-note">
                Praktik Bidan Mandiri BUMILOO<br>
                Terima kasih telah mempercayakan kesehatan Bunda pada kami.
            </div>
        </div>
    </div>
</body>
</html>