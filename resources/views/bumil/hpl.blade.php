@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold">HPL (Hari Perkiraan Lahir)</h4>
    <p class="text-muted mb-4">
        Masukkan tanggal HPHT untuk mengetahui perkiraan tanggal persalinan dan trimester kehamilan
    </p>

    <div class="row g-4">

        <!-- FORM -->
        <div class="col-md-5">

            <div class="card border-0 shadow-sm p-4" style="border-radius:20px;">

                <label class="fw-semibold mb-2">
                    Input Tanggal HPHT
                </label>

                <input type="date" id="hpht" class="form-control mb-4">

                <button class="btn text-white mb-3" onclick="hitungHPL()" style="background:#F875AA;">
                    Hitung HPL
                </button>

                <button class="btn btn-outline-secondary" onclick="resetForm()">
                    Reset
                </button>

            </div>

        </div>

        <!-- HASIL -->
        <div class="col-md-7">

            <div class="card border-0 shadow-sm p-4" style="border-radius:20px;">

                <h5 class="fw-bold mb-4">
                    Hasil Perhitungan
                </h5>

                <div class="mb-4">
                    <small class="text-muted">
                        Perkiraan HPL
                    </small>

                    <h3 class="text-pink fw-bold" id="hasil_hpl">
                        -
                    </h3>
                </div>

                <div class="mb-4">
                    <small class="text-muted">
                        Usia Kehamilan Saat Ini
                    </small>

                    <h4 class="text-pink fw-bold" id="usia_kehamilan">
                        -
                    </h4>
                </div>

                <div>
                    <small class="text-muted">
                        Trimester
                    </small>

                    <h4 class="text-pink fw-bold" id="trimester">
                        -
                    </h4>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
function hitungHPL() {
    let hphtInput = document.getElementById('hpht').value;

    if (!hphtInput) {
        alert('Silakan pilih tanggal HPHT');
        return;
    }

    let hpht = new Date(hphtInput);

    // =========================
    // HITUNG HPL
    // =========================
    let hpl = new Date(hpht);

    hpl.setDate(hpl.getDate() + 280);

    // =========================
    // HITUNG USIA KEHAMILAN
    // =========================
    let today = new Date();

    let diffTime = today - hpht;

    let totalHari = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    let minggu = Math.floor(totalHari / 7);

    let hari = totalHari % 7;

    // =========================
    // HITUNG TRIMESTER
    // =========================
    let trimester = '';

    if (minggu <= 13) {
        trimester = 'Trimester 1';
    } else if (minggu <= 27) {
        trimester = 'Trimester 2';
    } else {
        trimester = 'Trimester 3';
    }

    // =========================
    // FORMAT TANGGAL
    // =========================
    let options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    let hplFormatted = hpl.toLocaleDateString('id-ID', options);

    // =========================
    // TAMPILKAN HASIL
    // =========================
    document.getElementById('hasil_hpl').innerHTML = hplFormatted;

    document.getElementById('usia_kehamilan').innerHTML =
        minggu + ' Minggu ' + hari + ' Hari';

    document.getElementById('trimester').innerHTML =
        trimester;
}

function resetForm() {
    document.getElementById('hpht').value = '';

    document.getElementById('hasil_hpl').innerHTML = '-';

    document.getElementById('usia_kehamilan').innerHTML = '-';

    document.getElementById('trimester').innerHTML = '-';
}
</script>

@endsection