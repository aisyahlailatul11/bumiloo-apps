<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Gagal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="card shadow-lg border-0 rounded-4 text-center p-4" style="max-width:460px; width:100%;">
        
        <div class="mb-3">
            <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center"
                 style="width:80px; height:80px;">
                <i class="fas fa-times-circle text-white fa-3x"></i>
            </div>
        </div>

        <h4 class="fw-bold text-danger mb-1">Dokumen Tidak Valid</h4>
        <p class="text-muted mb-4" style="font-size:13px;">
            Kode verifikasi tidak ditemukan atau dokumen ini tidak terdaftar dalam sistem.
        </p>

        <div class="bg-light rounded-3 p-3 mb-3">
            <small class="text-muted">Kode yang dicoba:</small>
            <div class="fw-bold text-danger" style="font-size:12px; word-break:break-all;">{{ $token }}</div>
        </div>

        <small class="text-muted">
            <i class="fas fa-shield-alt text-danger me-1"></i>
            Sistem Bumiloo Apps
        </small>
    </div>
</body>
</html>