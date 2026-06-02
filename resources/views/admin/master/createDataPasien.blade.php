@extends('layouts.masterAdmin')

@section('title', 'Tambah Data Pasien')

@section('content')
<main class="p-10" style="font-family: 'Poppins', sans-serif; min-height: 100vh;">
    
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #0F172A;">Tambah Data Pasien</h1>
        <a href="{{ route('admin.master.pasien') }}" style="color: #64748B; text-decoration: none; font-weight: 600;">&larr; Kembali</a>
    </div>

    <div class="jwl-form-box">
        <form action="{{ route('admin.master.store') }}" method="POST">
            @csrf

<form action="..." method="POST">
    @csrf
    <div class="form-grid-3">
        
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" class="form-input" placeholder="Nama Lengkap" required></div>
        <div class="form-group"><label>NIK Pasien</label><input type="text" name="nik" class="form-input" placeholder="16 Digit No.KTP" maxlength="16" required></div>
        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-input" placeholder="Kota Kelahiran" required></div>
        <div class="form-group"><label>Tanggal Lahir Ibu</label><input type="date" id="tgl_lahir" name="tgl_lahir" class="form-input" placeholder="Tanggal Lahir Ibu" required></div>
        <div class="form-group"><label>Umur Ibu</label><input type="number" id="umur" name="umur" class="form-input readonly-medis" placeholder="Otomatis" readonly required></div>

        <div class="form-group"><label>Nomor WhatsApp</label><input type="text" name="no_hp" class="form-input" placeholder="Nomor Whatsapp" required></div>
        <div class="form-group"><label>Email Pasien (Opsional)</label><input type="email" name="email" class="form-input" placeholder="Email"></div>
        <div class="form-group"></div> <div class="form-group" style="grid-column: span 3;"><label>Alamat Domisili</label><input type="text" name="alamat" class="form-input" placeholder="Alamat Lengkap" required></div>

        <div class="form-group">
            <label>Agama</label>
            <select name="agama" class="form-input" required>
                <option value="">--Pilih Agama--</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pendidikan</label>
            <select name="pendidikan" class="form-input" required>
                <option value="">--Pilih Pendidikan--</option>
                        <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                        <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3 / Diploma</option>
                        <option value="S1/D4" {{ old('pendidikan') == 'S1/D4' ? 'selected' : '' }}>S1 / D4 </option>
                        <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
            </select>
        </div>
        <div class="form-group dropdown-container">
    <label>Pekerjaan Ibu</label>
    <select id="pekerjaan_select" name="pekerjaan" class="form-input" onchange="togglePekerjaan(this.value)" required>
        <option value="">--Pilih Pekerjaan--</option>
        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
        <option value="PNS / ASN">PNS / ASN</option>
        <option value="Karyawan Swasta">Karyawan Swasta</option>
        <option value="Wiraswasta">Wiraswasta</option>
        <option value="Lainnya">Lainnya...</option>
    </select>
    
    <div id="kotak_lainnya" style="display:none; margin-top:10px;">
        <input type="text" id="input_manual" name="pekerjaan_lainnya" class="form-input" placeholder="Tulis Pekerjaan Anda">
    </div>
</div>
        <div class="form-group">
            <label>Golongan Darah</label>
            <select name="gol_darah" class="form-input" required>
                <option value="">--Pilih Gol. Darah--</option>
                    <option value="A" {{ old('gol_darah') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('gol_darah') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('gol_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ old('gol_darah') == 'O' ? 'selected' : '' }}>O</option>
            </select>
        </div>
        <div class="form-group" style="grid-column: span 2;">
            <label>HPHT (Hari Pertama Haid Terakhir)</label>
    <input type="date" name="hpht" class="form-input" style="border: 1.5px solid #F9A8D4; border-radius: 12px;" placeholder="HPHT" required></div>

        <div class="section-divider" style="grid-column: span 3;">Data Suami</div>
        <div class="form-group"><label>Nama Suami</label><input type="text" name="nama_suami" class="form-input" placeholder="Nama Suami" required></div>
        <div class="form-group"><label>Tanggal Lahir Suami</label><input type="date" id="tgllahir_suami" name="tgllahir_suami" class="form-input" placeholder="Tanggal Lahir Suami" required></div>
        <div class="form-group"><label>Umur Suami</label><input type="number" id="usia_suami" name="usia_suami" class="form-input readonly-medis" placeholder="Otomatis" readonly required></div>

    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
        <button type="submit" class="btn-submit-premium">Simpan</button>
    </div>
</form>

</main>

<style>
    .jwl-form-box { background: #FFFFFF; padding: 40px; border-radius: 24px; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .form-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr) !important; gap: 15px; align-items: start; }
    .form-grid-3 .form-group { grid-column: span 1; width: 100%;}
    .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid #CBD5E1; border-radius: 12px; font-size: 14px; }
    .form-input:focus { border-color: #F84F8F; outline: none; box-shadow: 0 0 0 4px rgba(248, 79, 143, 0.1); }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 13px; }
    .section-divider { grid-column: span 3; font-size: 18px; font-weight: 700; color: #F84F8F; margin: 25px 0 15px 0; border-bottom: 2px solid #FBCFE8; padding-bottom: 5px; }
    .readonly-medis { background-color: #F1F5F9; color: #64748B; cursor: not-allowed; }
    .btn-submit-premium { background: #F84F8F; color: white; padding: 14px 40px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; margin-top: 30px; transition: 0.3s; }
    .btn-submit-premium:hover { background: #e03e7a; transform: translateY(-2px); }
</style>

    <script>
    // 1. Logika Toggle Pekerjaan
    const selPekerjaan = document.getElementById('pekerjaan_select');
    const boxLainnya = document.getElementById('kotak_lainnya');
    const inpManual = document.getElementById('input_manual');

    function togglePekerjaan(val) {
        if (val === 'Lainnya') {
            boxLainnya.style.display = 'block';
            inpManual.setAttribute('name', 'pekerjaan');
            selPekerjaan.removeAttribute('name');
        } else {
            boxLainnya.style.display = 'none';
            selPekerjaan.setAttribute('name', 'pekerjaan');
            inpManual.removeAttribute('name');
        }
    }

    // 2. Fungsi Kalkulator Umur (Ibu & Suami)
    function calcAge(birthDate) {
        if (!birthDate) return '';
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        return age < 0 ? 0 : age;
    }

    // Event Listener untuk Ibu
    document.getElementById('tgl_lahir').addEventListener('change', function() {
        document.getElementById('umur').value = calcAge(this.value);
    });

    // Event Listener untuk Suami
    document.getElementById('tgllahir_suami').addEventListener('change', function() {
        document.getElementById('usia_suami').value = calcAge(this.value);
    });

    // 3. Inisialisasi saat halaman pertama kali dibuka
    window.addEventListener('DOMContentLoaded', () => {
        // Kalkulasi ulang jika data lama (old) tersedia
        if(document.getElementById('tgl_lahir').value) document.getElementById('umur').value = calcAge(document.getElementById('tgl_lahir').value);
        if(document.getElementById('tgllahir_suami').value) document.getElementById('usia_suami').value = calcAge(document.getElementById('tgllahir_suami').value);
        if(document.getElementById('hpht').value) document.getElementById('hpht').dispatchEvent(new Event('change'));
        
        // Handle inputan 'Lainnya' jika ada error validasi
        const oldPek = "{{ old('pekerjaan') }}";
        if(oldPek && !['Ibu Rumah Tangga','PNS / ASN','Karyawan Swasta','Wiraswasta'].includes(oldPek)) {
            selPekerjaan.value = 'Lainnya';
            inpManual.value = oldPek;
            togglePekerjaan('Lainnya');
        } else if(oldPek) {
            selPekerjaan.value = oldPek;
        }
    });
</script>
    @include('partials.alerts')

@endsection