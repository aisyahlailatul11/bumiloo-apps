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
                <label class="form-label">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal_pemeriksaan" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Waktu Pemeriksaan</label>
                <input type="time" name="waktu_pemeriksaan" class="form-control">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Data Kehamilan</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Usia Kehamilan</label>
                <input type="text" name="usia_kehamilan" class="form-control" placeholder="Minggu / Hari">
            </div>
            <div class="col-md-4">
                <label class="form-label">Trimester</label>
                <input type="number" name="trimester" class="form-control" placeholder="1 / 2 / 3">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kehamilan Ke- (Gravida)</label>
                <input type="number" name="kehamilan_ke" class="form-control" placeholder="Contoh: 1">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">HPHT</label>
                <input type="date" name="hpht" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">HPL</label>
                <input type="date" name="hpl" class="form-control">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Riwayat Kesehatan</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Riwayat Penyakit</label>
                <input type="text" name="riwayat_penyakit" class="form-control" placeholder="Tulis (-) jika tidak ada">
            </div>
            <div class="col-md-6">
                <label class="form-label">Riwayat Alergi</label>
                <input type="text" name="riwayat_alergi" class="form-control" placeholder="Tulis (-) jika tidak ada">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Hasil Pemeriksaan</h5>
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Berat Badan (kg)</label>
                <input type="number" step="0.01" name="berat_badan" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tinggi Badan (cm)</label>
                <input type="number" step="0.01" name="tinggi_badan" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">IMT (Indeks Massa Tubuh)</label>
                <input type="number" step="0.01" name="imt" class="form-control" placeholder="Otomatis / Manual">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tekanan Darah (mmHg)</label>
                <input type="text" name="tekanan_darah" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Tinggi Fundus Uteri (cm)</label>
                <input type="number" name="tinggi_fundus" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">LILA (Lingkar Lengan Atas - cm)</label>
                <input type="number" step="0.01" name="lila" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">DJJ (x/menit)</label>
                <input type="number" name="djj" class="form-control">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Keluhan</h5>
        <textarea name="keluhan" class="form-control mb-3" rows="3" placeholder="Tuliskan keluhan pasien"></textarea>

        <h5 class="fw-bold text-pink mb-3">Tindakan / Saran Bidan</h5>
        <textarea name="tindakan" class="form-control mb-3" rows="3" placeholder="Tuliskan saran atau tindakan"></textarea>

        <h5 class="fw-bold text-pink mb-3">Obat yang Diberikan</h5>
        <textarea name="obat" class="form-control mb-3" rows="2" placeholder="Tuliskan obat yang diberikan"></textarea>

        <h5 class="fw-bold text-pink mb-3">Catatan Tambahan</h5>
        <textarea name="catatan_tambahan" class="form-control mb-3" rows="2" placeholder="Catatan tambahan"></textarea>

        <div class="text-end gap-2 d-flex justify-content-end">
            <a href="{{ route('bidan.inputDaftarPasien') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            
            <button type="reset" class="btn btn-warning text-dark">
                <i class="fas fa-undo me-1"></i> Reset
            </button>
            
            <button type="submit" class="btn text-white" style="background-color:#f875aa;">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
function validasiFormPerkembangan(event) {
    const form = document.getElementById('formPerkembangan');
    
    const kolomWajib = [
        'tanggal_pemeriksaan', 'waktu_pemeriksaan', 'usia_kehamilan', 
        'trimester', 'kehamilan_ke', 'hpht', 'hpl',
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