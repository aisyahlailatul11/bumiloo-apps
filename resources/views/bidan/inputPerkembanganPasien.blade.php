@extends('layouts.masterBidan')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4 text-pink">Input Perkembangan Pasien</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center"
             role="alert"
             style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
                    z-index: 9999; display: inline-block; max-width: 80%; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('bidan.inputPerkembangan') }}" method="POST" id="formPerkembangan" 
          onsubmit="return validasiFormPerkembangan(event)" class="card shadow p-4 mb-4">
        @csrf
        <input type="hidden" name="pasien_id" value="{{ request()->get('pasien_id') }}">

        <h5 class="fw-bold text-pink mb-3">Data Pemeriksaan</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_pemeriksaan" class="form-control" required>
            </div>
            <div class="col-md-6">
             <label class="form-label">Waktu Pemeriksaan <span class="text-danger">*</span></label>
            <div class="input-group">
           <input type="time" name="waktu_pemeriksaan" class="form-control" step="60" required>
            <span class="input-group-text">WIB</span>
            </div>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Data Kehamilan</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Usia Kehamilan <span class="text-danger">*</span></label>
                <select name="usia_kehamilan" id="select_usia_kehamilan" class="form-select" required>
                    <option value="">-- Usia Kehamilan --</option>
                    @for ($i = 1; $i <= 40; $i++)
                        <option value="{{ $i }}">{{ $i }} minggu</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Trimester</label>
                <input type="number" name="trimester" id="select_trimester" class="form-control" 
                       style="background-color: #e9ecef;" readonly required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kehamilan Ke- (Gravida) <span class="text-danger">*</span></label>
                <select name="kehamilan_ke" class="form-select" required>
                    <option value="">-- Kehamilan Ke- --</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Riwayat Kesehatan</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Riwayat Penyakit <span class="text-danger">*</span></label>
                <select id="select_riwayat_penyakit" class="form-select mb-2" required>
                    <option value="-">-- Riwayat Penyakit --</option>
                    <option value="-">Tidak Ada (-)</option>
                    <option value="Hipertensi">Hipertensi</option>
                    <option value="Diabetes">Diabetes</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Paru-Paru">Paru-Paru</option>
                    <option value="Kanker">Kanker</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
                <div id="riwayat_manual_box" style="display:none;">
                    <input type="text" name="riwayat_penyakit" id="input_riwayat_penyakit" 
                           class="form-control" placeholder="Tulis riwayat penyakit pasien" required>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Riwayat Alergi</label>
                <input type="text" name="riwayat_alergi" class="form-control" placeholder="Tulis (-) jika tidak ada">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Hasil Pemeriksaan</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="berat_badan" id="berat_badan" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" class="form-control" required>
            </div>
            <div class="col-md-4   ">
                <label class="form-label">IMT</label>
                <input type="number" step="0.01" name="imt" id="imt" class="form-control" 
                       placeholder="Otomatis" readonly style="background-color: #e9ecef;" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Tekanan Darah (mmHg) <span class="text-danger">*</span></label>
                <input type="text" name="tekanan_darah" class="form-control" placeholder="Contoh: 120/80" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tinggi Fundus Uteri (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="tinggi_fundus" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">LILA (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="10" max="99.99" name="lila" class="form-control" placeholder="Contoh: 23.5" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Denyut Jantung Janin (DJJ) <span class="text-danger">*</span></label>
                <input type="number" name="djj" class="form-control" placeholder="Contoh: 140" required>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Keluhan <span class="text-danger">*</span></h5>
        <textarea name="keluhan" class="form-control mb-3" rows="3" placeholder="Tuliskan keluhan pasien" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Tindakan / Saran Bidan <span class="text-danger">*</span></h5>
        <textarea name="tindakan" class="form-control mb-3" rows="3" placeholder="Tuliskan saran atau tindakan" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Obat yang Diberikan <span class="text-danger">*</span></h5>
        <textarea name="obat" class="form-control mb-3" rows="2" placeholder="Tuliskan obat yang diberikan" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Catatan Tambahan</h5>
        <textarea name="catatan_tambahan" class="form-control mb-3" rows="2" placeholder="Catatan tambahan (Opsional)"></textarea>

        <div class="text-end gap-2 d-flex justify-content-end">
            <a href="{{ route('bidan.inputDaftarPasien') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            <button type="reset" class="btn btn-warning text-dark" id="btnResetForm">
                <i class="fas fa-undo me-1"></i> Reset
            </button>
            
            <button type="submit" class="btn text-white" style="background-color:#f875aa;">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectUsia = document.getElementById('select_usia_kehamilan');
    const inputTrimester = document.getElementById('select_trimester');

    function hitungTrimester() {
        const usia = parseInt(selectUsia.value);
        if (!isNaN(usia)) {
            if (usia >= 1 && usia <= 13) {
                inputTrimester.value = 1;
            } else if (usia >= 14 && usia <= 27) {
                inputTrimester.value = 2;
            } else if (usia >= 28 && usia <= 40) {
                inputTrimester.value = 3;
            } else {
                inputTrimester.value = '';
            }
        } else {
            inputTrimester.value = '';
        }
    }

    if (selectUsia) {
        selectUsia.addEventListener('change', hitungTrimester);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const inputBB = document.getElementById('berat_badan');
    const inputTB = document.getElementById('tinggi_badan');
    const inputIMT = document.getElementById('imt');

    function hitungIMT() {
        const bb = parseFloat(inputBB.value);
        const tb = parseFloat(inputTB.value) / 100; // cm -> m
        if (bb > 0 && tb > 0) {
            const imt = (bb / (tb * tb)).toFixed(2);
            inputIMT.value = imt;
        } else {
            inputIMT.value = '';
        }
    }

    if (inputBB && inputTB) {
        inputBB.addEventListener('input', hitungIMT);
        inputTB.addEventListener('input', hitungIMT);
    }

    // Reset form
    const btnReset = document.getElementById('btnResetForm');
    const inputTrimester = document.getElementById('select_trimester');
    const inputManual = document.getElementById('input_riwayat_penyakit');
    const boxManual = document.getElementById('riwayat_manual_box');
    const selectPenyakit = document.getElementById('select_riwayat_penyakit');

    if (btnReset) {
        btnReset.addEventListener('click', function() {
            setTimeout(() => {
                hitungIMT();
                if (inputManual) {
                    boxManual.style.display = 'none';
                    inputManual.value = '';
                    inputManual.required = false;
                }
                if (inputTrimester) {
                    inputTrimester.value = '';
                }
            }, 10);
        });
    }

  
    if (selectPenyakit) {
        selectPenyakit.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                boxManual.style.display = 'block';
                inputManual.required = true;
                inputManual.value = '';
            } else {
                boxManual.style.display = 'none';
                inputManual.required = false;
                inputManual.value = this.value; 
            }
        });
    }

    // Validasi form
    window.validasiFormPerkembangan = function(event) {
        const form = document.getElementById('formPerkembangan');
        const kolomWajib = [
            'tanggal_pemeriksaan','waktu_pemeriksaan','usia_kehamilan',
            'trimester','kehamilan_ke','riwayat_penyakit','berat_badan',
            'tinggi_badan','imt','tekanan_darah','tinggi_fundus','lila',
            'djj','keluhan','tindakan','obat'
        ];

        let adaYangKosong = false;
        kolomWajib.forEach(namaKolom => {
            const input = form.querySelector(`[name="${namaKolom}"]`);
            if (input && input.value.trim() === '') {
                adaYangKosong = true;
                input.style.borderColor = '#dc3545';
            } else if (input) {
                input.style.borderColor = '';
            }
        });

        if (adaYangKosong) {
            event.preventDefault();
            alert("Kolom tidak boleh kosong (Kecuali Catatan Tambahan)!");
            return false;
        }
        return true;
    };

    // Auto hide alert sukses
    setTimeout(() => {
        let alertSukses = document.querySelector('.alert');
        if (alertSukses) {
            alertSukses.classList.remove('show');
            setTimeout(() => alertSukses.remove(), 500);
        }
    }, 4000);
});

const waktuInput = document.querySelector('[name="waktu_pemeriksaan"]');
waktuInput.addEventListener('change', function() {
    if (this.value) {
        let [jam, menit] = this.value.split(':');
        jam = jam.padStart(2, '0');
        this.value = `${jam}:${menit}`; // format 24 jam
    }
});
</script>
@endsection
