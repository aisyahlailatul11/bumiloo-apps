<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Pelayanan Kesehatan Ibu</title>
    <style>
        @page { size: A4; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #222; background: #fff; }
        .wrapper { padding: 15mm; }

        /* KOP */
        .kop { display: table; width: 100%; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 15px; }
        .kop-left { display: table-cell; vertical-align: middle; width: 60px; }
        .kop-left img { width: 50px; }
        .kop-brand { display: table-cell; vertical-align: middle; color: #e83e8c; font-size: 14px; font-weight: 900; }
        .kop-center { display: table-cell; vertical-align: middle; text-align: center; }
        .kop-center h2 { font-size: 14px; }
        .kop-right { display: table-cell; vertical-align: middle; text-align: right; font-size: 9px; }

        /* JUDUL */
        .judul { text-align: center; margin-bottom: 20px; }
        .judul h2 { text-transform: uppercase; margin-bottom: 5px; }
        
        .section-title { font-weight: bold; margin-bottom: 8px; text-transform: uppercase; border-left: 3px solid #e83e8c; padding-left: 8px; }
        .para { line-height: 1.6; margin-bottom: 15px; text-align: justify; }

        /* TABEL */
        .table-ringkasan { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-ringkasan th { background: #e83e8c; color: #fff; padding: 8px; }
        .table-ringkasan td { padding: 8px; border: 1px solid #ddd; }

        /* TTD */
        .ttd { text-align: right; margin-top: 80px; }
        .ttd-space { height: 60px; }
    </style>
</head>
<body>
<div class="wrapper">

@php
    use Carbon\Carbon;
    // Mengambil tanggal dari database jika ada, jika tidak default ke hari ini
    $tAwal = request('tanggal_awal') ? Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') : Carbon::now()->startOfMonth()->translatedFormat('d F Y');
    $tAkhir = request('tanggal_akhir') ? Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') : Carbon::now()->endOfMonth()->translatedFormat('d F Y');
@endphp

<div class="kop">
    <div class="kop-left"><img src="{{ public_path('images/Logo_bumiloo.png') }}"></div>
    <div class="kop-brand">Bumiloo</div>
    <div class="kop-center">
        <h2>Praktik Bidan Mandiri Siti Fatimah</h2>
        <p>Jl. Melati No. 2, Kab. Jember</p>
    </div>
</div>

<div class="judul">
    <h2>Laporan Monitoring Pelayanan Kesehatan Ibu</h2>
    <p>PERIODE : {{ strtoupper($tAwal) }} S.D {{ strtoupper($tAkhir) }}</p>
</div>

<div class="section-title">I. Pendahuluan</div>
<p class="para">Laporan ini dibuat sebagai bentuk monitoring dan evaluasi pelayanan kesehatan ibu hamil di Klinik Praktik Bidan Mandiri. Data yang disajikan mencakup jumlah kunjungan, perkembangan ibu hamil, serta kasus kelainan kehamilan.</p>

<div class="section-title">II. Ringkasan Hasil Laporan</div>
<table class="table-ringkasan">
    <tr><th>Keterangan</th><th>Jumlah</th></tr>
    <tr><td>Total Kunjungan</td><td>{{ $data->count() }}</td></tr>
    <tr><td>Total Ibu Hamil</td><td>{{ $data->pluck('pasien_id')->unique()->count() }}</td></tr>
    <tr><td>Total Persalinan</td><td>{{ $data->where('jenis_layanan', 'Persalinan')->count() }}</td></tr>
    <tr><td>Trimester 1, 2, 3</td><td>{{ $data->where('trimester', 1)->count() }}, {{ $data->where('trimester', 2)->count() }}, {{ $data->where('trimester', 3)->count() }}</td></tr>
</table>

<div class="section-title">III. Pembahasan</div>
<p class="para">Berdasarkan hasil laporan, tercatat total kunjungan ibu hamil yang telah terdokumentasi dalam sistem Bumiloo. Data ini akan digunakan sebagai acuan tindak lanjut medis lebih lanjut.</p>

<div class="ttd">
    <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    <div class="ttd-space"></div>
    <p><b>Super Admin Bumiloo</b></p>
</div>

</div>
</body>
</html>