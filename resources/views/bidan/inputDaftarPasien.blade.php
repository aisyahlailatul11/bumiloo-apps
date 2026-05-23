@extends('layouts.masterBidan')

@section('content')
<style>
    .psn-container * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box !important; }
    .psn-table-wrapper { width: 100% !important; overflow-x: auto !important; border: 1px solid #D2D6DC !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0,0,0,0.05) !important; margin-top: 20px; }
    .psn-table-box { width: 100% !important; border-collapse: collapse !important; min-width: 1700px !important; } 
    .psn-table-box th { background-color: #F875AA !important; color: white !important; padding: 14px 12px !important; font-weight: 600 !important; font-size: 13px !important; border: none !important; text-align: left !important; white-space: nowrap !important; }
    .psn-table-box td { padding: 14px 12px !important; font-size: 13px !important; border-bottom: 1px solid #E2E8F0 !important; background-color: #FFFFFF !important; color: #333333 !important; white-space: nowrap !important; }
    .psn-row-normal:nth-child(even) td { background-color: #FFF5F7 !important; }
</style>

<div class="container-lg mt-4">
    <h3 class="fw-bold mb-4 text-dark">Input Data Ibu Hamil</h3>

    <form action="{{ route('bidan.pasien.store') }}" method="POST" class="card shadow p-4 mb-5" id="formPasien" onsubmit="return validasiFormBumil(event)">
    @csrf
        <input type="hidden" name="id" id="id_pasien">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">No. Pasien</label>
                <input type="text" name="no_pasien" class="form-control" readonly value="{{ $noPasienOtomatis }}" required>
            </div>
        </div>    
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK 16 Digit" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nama Pasien</label>
                <input type="text" name="nama_pasien" class="form-control" placeholder="Masukkan Nama Pasien" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>
               <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Umur</label>
                <input type="number" name="umur" id="umur" class="form-control" placeholder="" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label">Golongan Darah</label>
                <select name="golongan_darah" class="form-select" required>
                    <option value="">-- Pilih Golongan Darah --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukkan Nomor HP" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
               <label class="form-label">Pendidikan</label>
                <select name="pendidikan" class="form-select" required>
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="Diploma">D3</option>
                    <option value="S1">S1/D4</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Agama</label>
                <select name="agama" class="form-select" required>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Konghucu">Konghucu</option>
                    <option value="Budha">Budha</option>
                </select>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6" x-data="{ job: '' }">
                <label class="form-label">Pekerjaan</label>
                <select name="pekerjaan" x-model="job" required 
                class="form-select">
                <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                <option value="PNS">PNS</option>
                <option value="Wiraswasta">Wiraswasta</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input x-show="job === 'Lainnya'" type="text" name="pekerjaan_lainnya"
               placeholder="Masukkan Pekerjaan" 
               class="form-control mt-3 rounded-2xl border border-pink-200 bg-white">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nama Suami</label>
                <input type="text" name="nama_suami" class="form-control" 
                placeholder="Nama Suami" required>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-warning" onclick="resetFormPasien()">
                <i class="fas fa-undo"></i> Reset
            </button>
            <button type="submit" class="btn btn-success" id="btnSimpan">
                <i class="fas fa-plus"></i> Tambah
            </button>
            
            <button type="button" id="btnSelanjutnya" class="btn btn-secondary disabled" onclick="keHalamanSelanjutnya()">
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
                @foreach($pasien as $p)
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
function isiForm(id) {
    fetch('/bidan/pasien/' + id)
        .then(response => {
            if (!response.ok) throw new Error('Gagal memuat data dari server');
            return response.json();
        })
        .then(data => {
            document.getElementById('id_pasien').value = data.id;
            document.querySelector('[name="no_pasien"]').value = data.no_pasien;
            document.querySelector('[name="nik"]').value = data.nik;
            document.querySelector('[name="nama_pasien"]').value = data.nama_pasien;
            document.querySelector('[name="tempat_lahir"]').value = data.tempat_lahir;
            document.querySelector('[name="tanggal_lahir"]').value = data.tanggal_lahir;
            document.querySelector('[name="umur"]').value = data.umur;
            document.querySelector('[name="golongan_darah"]').value = data.golongan_darah;
            document.querySelector('[name="alamat"]').value = data.alamat;
            document.querySelector('[name="no_hp"]').value = data.no_hp;
            document.querySelector('[name="pendidikan"]').value = data.pendidikan;
            document.querySelector('[name="agama"]').value = data.agama;
            document.querySelector('[name="pekerjaan"]').value = data.pekerjaan;
            document.querySelector('[name="nama_suami"]').value = data.nama_suami;

            const btnSelanjutnya = document.getElementById('btnSelanjutnya');
            if (btnSelanjutnya) {
                btnSelanjutnya.classList.remove('btn-secondary', 'disabled');
                btnSelanjutnya.style.backgroundColor = '#f875aa';
                btnSelanjutnya.style.color = 'white';
            }

            const btnSimpan = document.getElementById('btnSimpan');
            if (btnSimpan) {
                btnSimpan.innerHTML = '<i class="fas fa-save"></i> Perbarui Data';
                btnSimpan.className = 'btn btn-info text-white';
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error(error);
            alert("Gagal memuat data pasien.");
        });
}

function keHalamanSelanjutnya() {
    const idPasien = document.getElementById('id_pasien').value;
    
    if (idPasien) {
        window.location.href = "{{ route('bidan.inputPerkembanganPasien') }}?pasien_id=" + idPasien;
    } else {
        window.location.href = "{{ route('bidan.inputPerkembanganPasien') }}";
    }
}

function resetFormPasien() {
    const form = document.getElementById('formPasien');
    if(form) form.reset();
    
    document.getElementById('id_pasien').value = '';
    
    const noPasienInput = document.querySelector('input[name="no_pasien"]');
    if(noPasienInput) {
        noPasienInput.value = "{{ $noPasienOtomatis ?? '' }}";
    }

    const btnSelanjutnya = document.getElementById('btnSelanjutnya');
    if (btnSelanjutnya) {
        btnSelanjutnya.className = 'btn btn-secondary disabled';
        btnSelanjutnya.style.backgroundColor = '';
    }

    const btnSimpan = document.getElementById('btnSimpan');
    if (btnSimpan) {
        btnSimpan.innerHTML = '<i class="fas fa-plus"></i> Tambah';
        btnSimpan.className = 'btn btn-success';
    }
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

document.addEventListener('DOMContentLoaded', function() {
    const inputTanggalLahir = document.getElementById('tanggal_lahir');
    const inputUmur = document.getElementById('umur');
    const seluruhInputForm = document.querySelectorAll('#formPasien input[required], #formPasien select[required]');

    function periksaKelengkapanForm() {
        let semuaSudahIsi = true;
        seluruhInputForm.forEach(input => {
            if (input.value.trim() === '') {
                semuaSudahIsi = false;
            }
        });

        const btnSelanjutnya = document.getElementById('btnSelanjutnya');
        if (btnSelanjutnya) {
            if (semuaSudahIsi) {
                btnSelanjutnya.classList.remove('btn-secondary', 'disabled');
                btnSelanjutnya.style.backgroundColor = '#f875aa';
                btnSelanjutnya.style.color = 'white';
            } else {
                if (!document.getElementById('id_pasien').value) {
                    btnSelanjutnya.className = 'btn btn-secondary disabled';
                    btnSelanjutnya.style.backgroundColor = '';
                }
            }
        }
    }

    seluruhInputForm.forEach(input => {
        input.addEventListener('input', periksaKelengkapanForm);
        input.addEventListener('change', periksaKelengkapanForm);
    });

    function hitungUmurOtomatis() {
        const tanggalLahir = new Date(inputTanggalLahir.value);
        const hariIni = new Date();

        if (isNaN(tanggalLahir) || tanggalLahir.getFullYear() < 1900) {
            inputUmur.value = '';
            return;
        }

        let umur = hariIni.getFullYear() - tanggalLahir.getFullYear();
        const bulan = hariIni.getMonth() - tanggalLahir.getMonth();

        if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tanggalLahir.getDate())) {
            umur--;
        }
        
        inputUmur.value = umur; 
        periksaKelengkapanForm();
    }

    inputTanggalLahir.addEventListener('change', hitungUmurOtomatis);
    inputTanggalLahir.addEventListener('input', hitungUmurOtomatis);
});
</script>

@if(session('sukses'))
    <div class="alert alert-success alert-dismissible fade show text-center"
         role="alert"
         style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
                z-index: 9999; display: inline-block; max-width: 80%;">
        {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('edited_id'))
        isiForm("{{ session('edited_id') }}");
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