<html>
<head>
    <title>Cetak Laporan</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf-style.css') }}">
    <style>
        @media print {
            @page { size: A4 portrait; margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print(); window.close();">
    @include('laporan.exportPdf')
</body>
</html>