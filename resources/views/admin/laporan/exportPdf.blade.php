<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4; margin: 40px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #000; padding: 20px; }

        /* HEADER KOP SURAT - Dibuat Center & Sejajar */
        /* HEADER KOP SURAT */
    .header { 
        position: relative; 
        text-align: center; 
        border-bottom: 2px solid #000; 
        padding-bottom: 10px; 
        margin-bottom: 5px; 
        min-height: 60px; /* Memberi ruang agar logo punya tempat */
    }.double-border { border-bottom: 4px double #000; margin-bottom: 20px; }
        
       .header-logo { 
        position: absolute; 
        left: 0; 
        top: -5px; /* Sesuaikan nilai ini: semakin negatif, semakin ke atas */
        width: 60px; 
    } .header-logo img { width: 100%; height: auto; }
        
        .header-text { display: inline-block; }
        .header-text h2 { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .header-text p { font-size: 11px; margin-top: 2px; }

        /* JUDUL LAPORAN */
        .judul { text-align: center; margin-bottom: 20px; }
        .judul h2 { font-size: 14px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .judul p { font-size: 10px; margin-top: 2px; }

        /* SECTION */
        .section-title { font-size: 11px; font-weight: bold; margin: 15px 0 5px 0; }
        .section p { font-size: 11px; line-height: 1.5; text-align: justify; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th { background-color: #f875aa; color: #fff; font-size: 9px; padding: 6px; border: 1px solid #ddd; text-align: center; }
        td { font-size: 9px; padding: 5px; border: 1px solid #ddd; text-align: center; }
        .total-data { font-size: 10px; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/Logo_bumiloo.png') }}" alt="Logo">
        </div>
        <div class="header-text">
            <h2>Praktik Bidan Mandiri Siti Fatimah</h2>
            <p>Jl. Melati No. 2, Kab. Jember</p>
        </div>
    </div>
    <div class="double-border"></div>

    <div class="judul">
        <h2>LAPORAN MONITORING PELAYANAN KESEHATAN IBU</h2>
        <p>PERIODE : {{ strtoupper(\Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('F Y')) }} s.d {{ strtoupper(\Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('F Y')) }}</p>
        <p>dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">I. PENDAHULUAN</div>
        <p>Laporan ini dibuat sebagai bentuk monitoring dan evaluasi pelayanan kesehatan ibu hamil di Klinik Praktik Bidan Mandiri selama periode {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('F Y') }} sampai dengan {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('F Y') }}.</p>
    </div>

    <div class="section">
        <div class="section-title">II. RINGKASAN HASIL LAPORAN</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nama</th><th>Tgl Periksa</th><th>Usia Kehamilan</th><th>Trimester</th><th>Jenis Layanan</th><th>BB</th><th>TB</th><th>IMT</th><th>Tek. Darah</th><th>DJJ</th><th>Keluhan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                <tr>
                    <td>{{ $row->pasien_id }}</td>
                    <td>{{ $row->pasien->nama_pasien ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->format('d/m/Y') }}</td>
                    <td>{{ $row->usia_kehamilan }}</td>
                    <td>{{ $row->trimester }}</td>
                    <td>{{ $row->jenis_layanan ?? '-' }}</td>
                    <td>{{ $row->berat_badan }}</td>
                    <td>{{ $row->tinggi_badan }}</td>
                    <td>{{ $row->imt }}</td>
                    <td>{{ $row->tekanan_darah }}</td>
                    <td>{{ $row->djj }}</td>
                    <td>{{ $row->keluhan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="12">Belum ada data pemeriksaan</td></tr>
                @endforelse
            </tbody>
        </table>
        <p class="total-data">Total: {{ $data->count() }} data</p>
    </div>

    <div class="section">
        <div class="section-title">IV. PEMBAHASAN</div>
        <p>Berdasarkan laporan periode ini, tercatat total {{ $data->count() }} kunjungan ibu hamil dengan {{ $data->count() }} laporan perkembangan yang berhasil dicatat dalam sistem. Terdapat {{ $data->whereNotNull('keluhan')->where('keluhan', '!=', '')->count() }} kasus kelainan kehamilan yang memerlukan perhatian dan tindak lanjut dari tenaga kesehatan.</p>
    </div>

</body>
</html>