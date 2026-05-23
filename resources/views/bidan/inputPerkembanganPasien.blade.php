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

    <form action="{{ route('bidan.inputPerkembangan') }}" method="POST" id="formPerkembangan" onsubmit="return validasiFormPerkembangan(event)" class="card shadow p-4 mb-4">
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
                <input type="time" name="waktu_pemeriksaan" class="form-control" required>
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
                <input type="number" name="trimester" id="select_trimester" class="form-control" style="background-color: #e9ecef; pointer-events: none;" tabindex="-1" readonly required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kehamilan Ke- (Gravida) <span class="text-danger">*</span></label>
                <select name="kehamilan_ke" class="form-select" required>
                    <option value="">-- Kehamilan Ke- --</option>
                    @for ($i = 1; $i <= 13; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Riwayat Kesehatan</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Riwayat Penyakit <span class="text-danger">*</span></label>
                <select id="select_riwayat_penyakit" class="form-select mb-2">
                    <option value="-">-- Riwayat Penyakit --</option>
                    <option value="-">Tidak Ada (-)</option>
                    <option value="Hipertensi">Hipertensi</option>
                    <option value="Diabetes">Diabetes</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Paru-Paru">Paru-Paru</option>
                    <option value="Kanker">Kanker</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
                <input type="text" name="riwayat_penyakit" id="input_riwayat_penyakit" 
                       class="form-control" value="-" readonly 
                       placeholder="Pilih 'Lainnya' untuk mengetik manual" style="background-color: #e9ecef;" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Riwayat Alergi <span class="text-danger">*</span></label>
                <input type="text" name="riwayat_alergi" class="form-control" placeholder="Tulis (-) jika tidak ada" required>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Hasil Pemeriksaan</h5>
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="berat_badan" id="berat_badan" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">IMT (Indeks Massa Tubuh)</label>
                <input type="number" step="0.01" name="imt" id="imt" class="form-control" placeholder="Otomatis" readonly style="background-color: #e9ecef;" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tekanan Darah (mmHg) <span class="text-danger">*</span></label>
                <input type="text" name="tekanan_darah" class="form-control" placeholder="Contoh: 120/80" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Tinggi Fundus Uteri (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="tinggi_fundus" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">LILA (Lingkar Lengan Atas - cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="10" max="99.99" name="lila" class="form-control" placeholder="Contoh: 23.5" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">DJJ (x/menit) <span class="text-danger">*</span></label>
                <input type="number" name="djj" class="form-control" required>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Keluhan <span class="text-danger">*</span></label>
        <textarea name="keluhan" class="form-control mb-3" rows="3" placeholder="Tuliskan keluhan pasien" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Tindakan / Saran Bidan <span class="text-danger">*</span></label>
        <textarea name="tindakan" class="form-control mb-3" rows="3" placeholder="Tuliskan saran atau tindakan"></textarea>

        <h5 class="fw-bold text-pink mb-3">Obat yang Diberikan <span class="text-danger">*</span></label>
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
    const inputBB = document.getElementById('berat_badan');
    const inputTB = document.getElementById('tinggi_badan');
    const inputIMT = document.getElementById('imt');
    const selectPenyakit = document.getElementById('select_riwayat_penyakit');
    const inputPenyakit = document.getElementById('input_riwayat_penyakit');
    const selectUsiaKehamilan = document.getElementById('select_usia_kehamilan');
    const inputTrimester = document.getElementById('select_trimester');
    const btnReset = document.getElementById('btnResetForm');

    if (selectUsiaKehamilan && inputTrimester) {
        selectUsiaKehamilan.addEventListener('change', function() {
            const minggu = parseInt(this.value);
            if (!minggu) {
                inputTrimester.value = "";
            } else if (minggu >= 1 && minggu <= 12) {
                inputTrimester.value = "1";
            } else if (minggu >= 13 && minggu <= 27) {
                inputTrimester.value = "2";
            } else if (minggu >= 28) {
                inputTrimester.value = "3";
            }
        });
    }
    if (selectPenyakit && inputPenyakit) {
        selectPenyakit.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                inputPenyakit.readOnly = false;
                inputPenyakit.value = '';
                inputPenyakit.style.backgroundColor = '#ffffff'; 
                inputPenyakit.placeholder = 'Silakan ketik riwayat penyakit di sini...';
                inputPenyakit.focus(); 
            } else {
                inputPenyakit.readOnly = true;
                inputPenyakit.value = this.value;
                inputPenyakit.style.backgroundColor = '#e9ecef';
                inputPenyakit.placeholder = "Pilih 'Lainnya' untuk mengetik";
            }
        });
    }

    function hitungIMT() {
        const bb = parseFloat(inputBB.value);
        const tb = parseFloat(inputTB.value) / 100; 
        if (bb > 0 && tb > 0) {
            const imt = bb / (tb * tb);
            inputIMT.value = imt.toFixed(2);
        } else {
            inputIMT.value = '';
        }
    }

    if (inputBB && inputTB) {
        inputBB.addEventListener('input', hitungIMT); 
        inputTB.addEventListener('input', hitungIMT); 
    }

    if (btnReset) {
        btnReset.addEventListener('click', function() {
            setTimeout(() => {
                hitungIMT();
                if (inputPenyakit) {
                    inputPenyakit.readOnly = true;
                    inputPenyakit.value = '-';
                    inputPenyakit.style.backgroundColor = '#e9ecef';
                }
                if (inputTrimester) {
                    inputTrimester.value = '';
                }
            }, 10);
        });
    }

    hitungIMT();
});

function validasiFormPerkembangan(event) {
    const form = document.getElementById('formPerkembangan');
    
    const kolomWajib = [
        'tanggal_pemeriksaan', 'waktu_pemeriksaan', 'usia_kehamilan', 
        'trimester', 'kehamilan_ke',
        'riwayat_penyakit', 'riwayat_alergi',
        'berat_badan', 'tinggi_badan', 'imt', 'tekanan_darah', 
        'tinggi_fundus', 'lila', 'djj', 'keluhan', 'tindakan', 'obat'
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
}

setTimeout(() => {
    let alertSukses = document.querySelector('.alert');
    if (alertSukses) {
        alertSukses.classList.remove('show');
        setTimeout(() => alertSukses.remove(), 500);
    }
}, 4000);
</script>
@endsection