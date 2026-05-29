@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                style="width:55px;height:55px;background:#F875AA;">
                <i class="bi bi-calendar-heart fs-3"></i>
            </div>

            <div>
                <h4 class="fw-bold mb-1">HPL (Hari Perkiraan Lahir)</h4>
                <p class="text-muted mb-0">
                    Hitung perkiraan tanggal persalinan, usia kehamilan, dan trimester Bunda
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- FORM INPUT --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:24px;">

                <div class="text-center mb-4">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center"
                        style="width:80px;height:80px;background:#FFE4EF;color:#F875AA;">
                        <i class="bi bi-calendar2-week fs-1"></i>
                    </div>

                    <h5 class="fw-bold mt-3 mb-1">Input Tanggal HPHT</h5>
                    <small class="text-muted">
                        Pilih hari pertama haid terakhir Bunda
                    </small>
                </div>

                <label class="fw-semibold mb-2">
                    <i class="bi bi-calendar-event text-pink"></i>
                    Tanggal HPHT
                </label>

                <input type="date" id="hpht" class="form-control form-control-lg mb-4 rounded-4">

                <button class="btn text-white mb-3 rounded-pill py-2 fw-semibold" onclick="hitungHPL()"
                    style="background:#F875AA;">
                    <i class="bi bi-calculator"></i>
                    Hitung HPL
                </button>

                <button class="btn btn-outline-secondary rounded-pill py-2 fw-semibold" onclick="resetForm()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Reset
                </button>

            </div>
        </div>

        {{-- HASIL --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius:24px;">

                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width:55px;height:55px;background:#FFE4EF;color:#F875AA;">
                        <i class="bi bi-clipboard-heart fs-3"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Hasil Perhitungan</h5>
                        <small class="text-muted">Hasil akan muncul setelah Bunda memilih tanggal HPHT</small>
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-md-12">
                        <div class="p-4 rounded-4" style="background:#FFF0F7;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                    style="width:55px;height:55px;color:#F875AA;">
                                    <i class="bi bi-calendar-check fs-3"></i>
                                </div>

                                <div>
                                    <small class="text-muted">Perkiraan HPL</small>
                                    <h3 class="text-pink fw-bold mb-0" id="hasil_hpl">-</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 rounded-4 h-100" style="background:#FFF7FB;">
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width:50px;height:50px;color:#F875AA;">
                                <i class="bi bi-hourglass-split fs-4"></i>
                            </div>

                            <small class="text-muted">Usia Kehamilan Saat Ini</small>
                            <h4 class="text-pink fw-bold mb-0" id="usia_kehamilan">-</h4>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-4 rounded-4 h-100" style="background:#FFF7FB;">
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mb-3"
                                style="width:50px;height:50px;color:#F875AA;">
                                <i class="bi bi-flower1 fs-4"></i>
                            </div>

                            <small class="text-muted">Trimester</small>
                            <h4 class="text-pink fw-bold mb-0" id="trimester">-</h4>
                        </div>
                    </div>

                </div>

                <div class="mt-4 p-3 rounded-4 border" style="border-color:#FFD1E5 !important;">
                    <i class="bi bi-heart-pulse text-pink"></i>
                    <span class="text-muted">
                        Hasil ini bersifat perkiraan. Tetap lakukan pemeriksaan rutin ke bidan atau fasilitas kesehatan.
                    </span>
                </div>

            </div>
        </div>

    </div>

</div>

<style>
.text-pink {
    color: #F875AA !important;
}

.form-control:focus {
    border-color: #F875AA;
    box-shadow: 0 0 0 0.2rem rgba(248, 117, 170, 0.18);
}
</style>

<script>
function hitungHPL() {
    let hphtInput = document.getElementById('hpht').value;

    if (!hphtInput) {
        Swal.fire({
            icon: 'warning',
            title: 'Tanggal HPHT belum dipilih',
            text: 'Silakan pilih tanggal HPHT terlebih dahulu.',
            confirmButtonColor: '#F875AA'
        });
        return;
    }

    let hpht = new Date(hphtInput);
    let hpl = new Date(hpht);
    hpl.setDate(hpl.getDate() + 280);

    let today = new Date();
    let diffTime = today - hpht;
    let totalHari = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    let minggu = Math.floor(totalHari / 7);
    let hari = totalHari % 7;

    let trimester = '';

    if (minggu <= 13) {
        trimester = 'Trimester 1';
    } else if (minggu <= 27) {
        trimester = 'Trimester 2';
    } else {
        trimester = 'Trimester 3';
    }

    let options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    document.getElementById('hasil_hpl').innerHTML =
        hpl.toLocaleDateString('id-ID', options);

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