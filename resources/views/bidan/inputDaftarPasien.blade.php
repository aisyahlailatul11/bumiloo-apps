@extends('layouts.masterBidan')

@section('content')
<style>
    .psn-container * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box !important; }
    .psn-table-wrapper { width: 100% !important; overflow-x: auto !important; border: 1px solid #D2D6DC !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0,0,0,0.05) !important; margin-top: 20px; }
    .psn-table-box { width: 100% !important; border-collapse: collapse !important; min-width: 1700px !important; } 
    .psn-table-box th { background-color: #F875AA !important; color: white !important; padding: 14px 12px !important; font-weight: 600 !important; font-size: 13px !important; border: none !important; text-align: left !important; white-space: nowrap !important; }
    .psn-table-box td { padding: 14px 12px !important; font-size: 13px !important; border-bottom: 1px solid #E2E8F0 !important; background-color: #FFFFFF !important; color: #333333 !important; white-space: nowrap !important; }
    .psn-container * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box !important; }
    .psn-row-normal:nth-child(even) td { background-color: #FFF5F7 !important; }
</style>

<div class="container-fluid">
    <h3 class="fw-bold mb-4 text-dark">Input Data Ibu Hamil</h3>

    @include('partials.alerts')


    <div>
         <a href="{{ route('bidan.daftarPasien') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
    </div>

    <form action="{{ route('bidan.pasien.store') }}" method="POST" class="card shadow p-4 mb-5" id="formPasien" onsubmit="return validasiFormBumil(event)">
    @csrf
        <input type="hidden" name="id" id="id_pasien">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">No. Pasien</label>
                <input type="text" name="no_pasien" class="form-control" placeholder="No. Pasien Otomatis"
       value="{{ old('no_pasien', $pasien->no_pasien ?? $noPasienOtomatis ?? '') }}"
       readonly>

            </div>
        </div>    
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">NIK</label>
               <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK 16 Digit" value="{{ old('nik', $pasien->nik ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nama Pasien</label>
                <input type="text" name="nama_pasien" 
       value="{{ old('nama_pasien', $pasien->nama_pasien ?? '') }}"
       class="form-control">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" value="{{ old('tempat_lahir', $pasien->tempat_lahir ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ?? '') }}" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Umur</label>
                <input type="number" name="umur" id="umur" class="form-control" 
       value="{{ old('umur', $pasien->umur ?? '') }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Golongan Darah</label>
                <select name="golongan_darah" class="form-select" required>
    <option value="">-- Pilih Golongan Darah --</option>
    <option value="A" {{ old('golongan_darah', $pasien->golongan_darah ?? '') == 'A' ? 'selected' : '' }}>A</option>
    <option value="B" {{ old('golongan_darah', $pasien->golongan_darah ?? '') == 'B' ? 'selected' : '' }}>B</option>
    <option value="AB" {{ old('golongan_darah', $pasien->golongan_darah ?? '') == 'AB' ? 'selected' : '' }}>AB</option>
    <option value="O" {{ old('golongan_darah', $pasien->golongan_darah ?? '') == 'O' ? 'selected' : '' }}>O</option>
</select>

            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" value="{{ old('alamat', $pasien->alamat ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">No. HP</label>
                 <input type="text" name="no_hp" class="form-control" placeholder="Masukkan Nomor HP" value="{{ old('no_hp', $pasien->no_hp ?? '') }}" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
               <label class="form-label">Pendidikan</label>
                <select name="pendidikan" class="form-select" required>
                     <option value="SD" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                        <option value="D3" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'D3' ? 'selected' : '' }}>D3 / Diploma</option>
                        <option value="S1/D4" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'S1/D4' ? 'selected' : '' }}>S1 / D4 / Sarjana</option>
                        <option value="S2" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan', $pasien->pendidikan ?? '') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Agama</label>
                <select name="agama" class="form-select" required>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ old('agama', $pasien->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama', $pasien->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Hindu" {{ old('agama', $pasien->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Konghucu" {{ old('agama', $pasien->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option> 
                    <option value="Budha" {{ old('agama', $pasien->agama ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
                </select>
            </div>
        </div>
        
       <div class="row mb-4">
    <div class="col-md-6">
        <label class="form-label">Pekerjaan</label>
        
        <select id="pilihan_pekerjaan" name="pekerjaan" class="form-select" required 
                onchange="document.getElementById('kotak_lainnya').style.setProperty('display', this.value === 'Lainnya' ? 'block' : 'none', 'important'); document.getElementById('input_manual').required = (this.value === 'Lainnya');">
              <option value="">Pilih Pekerjaan</option>
                        <option value="Ibu Rumah Tangga"{{ old('pekerjaan', $pasien->pekerjaan ?? '') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                        <option value="PNS / ASN"{{ old('pekerjaan', $pasien->pekerjaan ?? '') == 'PNS / ASN' ? 'selected' : '' }}>PNS / ASN</option>
                        <option value="Karyawan Swasta"{{ old('pekerjaan', $pasien->pekerjaan ?? '') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Wiraswasta"{{ old('pekerjaan', $pasien->pekerjaan ?? '') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Lainnya"{{ old('pekerjaan', $pasien->pekerjaan ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya...</option>
        </select>
        
        <div id="kotak_lainnya" class="mt-2" style="display: none !important;">
            <input type="text" id="input_manual" name="pekerjaan_lainnya" value="{{ old('pekerjaan_lainnya') }}" class="form-control" placeholder="Tulis Pekerjaan Anda">
        </div>
    </div>

    <div class="col-md-6">
                <label class="form-label">Nama Suami</label>
                <input type="text" name="nama_suami" class="form-control" placeholder="Masukkan Nama Suami" value="{{ old('nama_suami', $pasien->nama_suami ?? '') }}" required>
            </div>
</div>

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-warning" onclick="resetFormPasien()">
                <i class="fas fa-undo"></i> Reset
            </button>
            <button type="submit" class="btn btn-success" id="btnSimpan">
                <i class="fas fa-user-plus"></i> Tambah
            </button>
            
            <button type="button" id="btnSelanjutnya"
        class="btn"
        style="background-color:#f875aa; color:white;"
        onclick="keHalamanSelanjutnya()">
    Selanjutnya <i class="fas fa-angle-double-right"></i>
</button>
        </div>
    </form>

<div class="psn-container w-full" style="padding: 10px 20px; background-color: #FFFFFF; min-h-screen;">
    
    <div style="margin-bottom: 10px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #000000; margin: 0;">Data Pasien Ibu Hamil</h1>
    </div>

    <div class="psn-table-wrapper">
        <table class="psn-table-box">
            <thead>
                <tr>
                    <th>No Pasien</th>
                    <th>NIK</th>
                    <th>Nama Pasien</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Umur</th>
                    <th>Gol. Darah</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Pendidikan</th>
                    <th>Agama</th>
                    <th>Pekerjaan</th>
                    <th>Nama Suami</th>
                </tr>
            </thead>
           <tbody style="white-space: nowrap;">
            @foreach($pasienMaster as $p)
            <tr class="psn-row-normal" onclick="isiForm('{{ $p->id }}')" style="cursor:pointer;">
                    <td>{{ $p->no_pasien }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->nama_pasien }}</td>
                    <td>{{ $p->tempat_lahir }}</td>
                    <td>{{ $p->tanggal_lahir }}</td>
                    <td>{{ $p->umur }} Th</td>
                    <td class="text-center">{{ $p->golongan_darah }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->no_hp }}</td>
                    <td>{{ $p->pendidikan }}</td>
                    <td>{{ $p->agama }}</td>
                    <td>{{ $p->pekerjaan }}</td>
                    <td>{{ $p->nama_suami }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function tampilkanManual() {
    const selectPekerjaan = document.getElementById('pilihan_pekerjaan');
    const kotakLainnya = document.getElementById('kotak_lainnya');
    const inputManual = document.getElementById('input_manual');

    if (selectPekerjaan.value === 'Lainnya') {
        kotakLainnya.style.display = 'block';   
        inputManual.required = true;            
    } else {
        kotakLainnya.style.display = 'none';   
        inputManual.required = false;         
        inputManual.value = '';              
    }
}

function isiForm(id) {
    fetch('/bidan/pasien/' + id)
        .then(response => {
            if (!response.ok) throw new Error('Gagal memuat data dari server');
            return response.json();
        })
        .then(data => {
            // Suntikkan data langsung menggunakan nama kolom asli database Anda
            if(document.getElementById('id_pasien')) document.getElementById('id_pasien').value = data.id || '';
            document.querySelector('[name="no_pasien"]').value = data.no_pasien || '';
            document.querySelector('[name="nik"]').value = data.nik || '';
            document.querySelector('[name="nama_pasien"]').value = data.nama_pasien || '';
            document.querySelector('[name="tempat_lahir"]').value = data.tempat_lahir || '';
            document.querySelector('[name="tanggal_lahir"]').value = data.tanggal_lahir || '';
            document.querySelector('[name="umur"]').value = data.umur || '';
            document.querySelector('[name="golongan_darah"]').value = data.golongan_darah || '';
            document.querySelector('[name="alamat"]').value = data.alamat || '';
            document.querySelector('[name="no_hp"]').value = data.no_hp || '';
            document.querySelector('[name="pendidikan"]').value = data.pendidikan || '';
            
            if(document.querySelector('[name="agama"]')) document.querySelector('[name="agama"]').value = data.agama || '';
            if(document.querySelector('[name="nama_suami"]')) document.querySelector('[name="nama_suami"]').value = data.nama_suami || '';

            // Bagian Logika Pekerjaan
            const selectPekerjaan = document.getElementById('pilihan_pekerjaan');
            const kotakLainnya = document.getElementById('kotak_lainnya');
            const inputManual = document.getElementById('input_manual');
            const opsiStandar = ['Ibu Rumah Tangga', 'PNS', 'Wiraswasta'];
            
            if (selectPekerjaan) {
                if (data.pekerjaan) {
                    if (opsiStandar.includes(data.pekerjaan)) {
                        selectPekerjaan.value = data.pekerjaan;
                        if(kotakLainnya) kotakLainnya.style.display = 'none';
                        if(inputManual) inputManual.removeAttribute('required');
                    } else {
                        selectPekerjaan.value = 'Lainnya';
                        if(kotakLainnya) kotakLainnya.style.display = 'block';
                        if(inputManual) {
                            inputManual.value = data.pekerjaan;
                            inputManual.setAttribute('required', 'required');
                        }
                    }
                }
            }

            // PENTING: Jalankan fungsi kelengkapan form setelah data sukses disuntikkan
            if (typeof periksaKelengkapanForm === 'function') {
                periksaKelengkapanForm();
            }

            // --- KODE MODIFIKASI TOMBOL DI MASUKKAN KE SINI (DALAM PROMISE FETCH) ---
            const btnSelanjutnya = document.getElementById('btnSelanjutnya');
            if (btnSelanjutnya) {
                btnSelanjutnya.className = 'btn';
                btnSelanjutnya.style.backgroundColor = '#f875aa';
                btnSelanjutnya.style.color = 'white';
            }

            const btnSimpan = document.getElementById('btnSimpan');
            if (btnSimpan) {
                btnSimpan.innerHTML = '<i class="fas fa-save"></i> Perbarui Data';
                btnSimpan.classList.remove('btn-success');
                btnSimpan.classList.add('btn-info', 'text-white');
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error(error);

            const container = document.createElement('div');
            container.className = "alert alert-danger alert-dismissible fade show text-center";
            container.style.cssText = "position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 80%;";
            container.innerHTML = `
                Gagal memuat data pasien.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(container);

            setTimeout(() => {
                container.classList.remove('show');
                container.remove(); // Menghapus element agar tidak menumpuk di DOM
            }, 4000);
        });
} // Akhir dari fungsi isiForm

function resetFormPasien() {
    const form = document.getElementById('formPasien');
    if(form) form.reset();
    
    document.getElementById('id_pasien').value = '';
    
    const noPasienInput = document.querySelector('input[name="no_pasien"]');
    if(noPasienInput) {
        noPasienInput.value = "{{ $noPasienOtomatis ?? '' }}";
    }

    const selectPekerjaan = document.getElementById('pilihan_pekerjaan') || document.querySelector('.form-select[x-model="job"]');
    if (selectPekerjaan && selectPekerjaan.__x) {
        selectPekerjaan.__x.$data.job = '';
    }

    const btnSelanjutnya = document.getElementById('btnSelanjutnya');
    if (btnSelanjutnya) {
        btnSelanjutnya.className = 'btn';
        btnSelanjutnya.style.backgroundColor = '';
    }

    const btnSimpan = document.getElementById('btnSimpan');
    if (btnSimpan) {
        btnSimpan.innerHTML = '<i class="fas fa-plus"></i> Tambah';
        btnSimpan.className = 'btn btn-success';
    }
}

// Ganti jadi ini:
function keHalamanSelanjutnya() {
    // Coba ambil dari hidden input dulu
    let pasienId = document.getElementById('id_pasien').value;
    
    // Kalau kosong, ambil dari URL langsung
    if (!pasienId) {
        const urlPath = window.location.pathname;
        const segments = urlPath.split('/');
        const idFromUrl = segments[segments.length - 1];
        if (idFromUrl && !isNaN(idFromUrl)) {
            pasienId = idFromUrl;
        }
    }
    
    if (!pasienId) {
        alert('Pilih pasien terlebih dahulu dari tabel di bawah!');
        return;
    }
    
    window.location.href = "{{ route('bidan.inputPerkembanganPasien') }}?pasien_id=" + pasienId;
}

function validasiFormBumil(event) {
    const form = document.getElementById('formPasien');
    if (!form.checkValidity()) {
        event.preventDefault(); 
        alert("Kolom tidak boleh kosong"); 
        return false; 
    } 
    return true; 
} 
</script>

@if(session('edited_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            isiForm("{{ session('edited_id') }}");
            const urlPath = window.location.pathname;
    const segments = urlPath.split('/');
    const idFromUrl = segments[segments.length - 1];
    
    // Kalau ada ID di URL dan angka, load data pasien otomatis
    if (idFromUrl && !isNaN(idFromUrl)) {
        isiForm(idFromUrl);
    }
        });
    </script>
@endif

<script>
    setTimeout(() => {
        let alert = document.querySelector('.alert');
        if(alert){
            alert.classList.remove('show');
        }
    }, 4000);
</script>
@endsection