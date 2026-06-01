<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen Sah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-lg border-0 rounded-4 text-center p-4" style="max-width:460px; width:100%;">
        
        <div class="mb-3">
            <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center"
                 style="width:80px; height:80px;">
                <i class="fas fa-check-circle text-white fa-3x"></i>
            </div>
        </div>

        <h4 class="fw-bold text-success mb-1">Dokumen Rekam Medis Sah</h4>
        <p class="text-muted mb-4" style="font-size:13px;">
            Dokumen ini telah diverifikasi dan ditandatangani secara digital
        </p>

        <div class="bg-light rounded-3 p-3 text-start mb-3">
            <table class="table table-sm table-borderless mb-0" style="font-size:13px;">
                <tr>
                    <td class="text-muted fw-bold" width="45%">Nama Pasien</td>
                    <td>: {{ $persalinan->pasien->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-bold">Tanggal Persalinan</td>
                    <td>: {{ \Carbon\Carbon::parse($persalinan->tanggal_persalinan)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-bold">Bidan Penanggung Jawab</td>
                    <td>: {{ $persalinan->nama_bidan }}</td>
                </tr>
                <tr>
                    <td class="text-muted fw-bold">Kode Verifikasi</td>
                    <td>: <span class="badge bg-success" style="font-size:10px;">{{ $persalinan->qr_signature_code }}</span></td>
                </tr>
            </table>
        </div>

        <small class="text-muted">
            <i class="fas fa-shield-alt text-success me-1"></i>
            Diverifikasi oleh Sistem Bumiloo Apps
        </small>
    </div>
</body>
</html>