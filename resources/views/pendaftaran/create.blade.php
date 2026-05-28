<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bumiloo - Pendaftaran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

 <style>
    :root {
        --bml-pink: #F875AA;
        --bml-blue: #4682B4;
        --text-main: #1A365D;
        --text-muted: #64748B;
    }

    * { box-sizing: border-box !important; font-family: 'Poppins', sans-serif !important; }

    html, body {
        margin: 0; padding: 0; min-height: 100vh;
        background: linear-gradient(135deg, #FFB6C1 0%, #FFD1DC 40%, #FFF0F5 100%) !important;
        display: flex; align-items: center; justify-content: center;
        overflow-x: hidden;
    }

    /* Floating Blobs */
    .floating-blobs {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1; pointer-events: none;
    }
    .blob {
        position: absolute; background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(40px); border-radius: 50%;
        animation: float 20s infinite ease-in-out;
    }
    .blob-1 { width: 400px; height: 400px; top: -100px; left: -100px; background: rgba(255, 222, 233, 0.5); }
    .blob-2 { width: 500px; height: 500px; bottom: -150px; right: -150px; background: rgba(248, 164, 220, 0.4); animation-delay: -5s; }
    .blob-3 { width: 250px; height: 250px; top: 20%; right: 10%; background: rgba(255, 250, 205, 0.4); animation-delay: -10s; }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    .pendaftaran-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        width: 95%; max-width: 900px;
        margin: 40px auto; padding: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); 
        position: relative; z-index: 10;
    }

    .header-section { text-align: center; margin-bottom: 40px; }
    .header-section h2 { font-size: 32px; font-weight: 800; color: var(--text-main); text-transform: uppercase; margin: 0; }
    .header-section p { color: var(--text-muted); font-size: 14px; margin-top: 8px; }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
    }
    @media (min-width: 768px) { .form-grid-3 { grid-template-columns: repeat(3, 1fr); } }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 2px; }
    
    .form-input { 
        width: 100%; padding: 12px 16px; 
        border: 1px solid #E2E8F0; 
        border-radius: 12px; 
        font-size: 13px;
        box-shadow: none !important;
        background: #FDFDFD;
    }
    .form-input:focus { border-color: var(--bml-pink); outline: none; }
    .readonly-medis { background-color: #F8FAFC !important; color: #64748B !important; border-style: dashed; }

    .kalkulator-medis-box {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 10px;
    }

    .hidden-pekerjaan { display: none; margin-top: 10px; }

    .btn-submit-premium {
        background: var(--bml-pink);
        color: white; padding: 16px 40px; border-radius: 12px;
        font-weight: 700; border: none; cursor: pointer;
        width: 100%; margin-top: 30px;
        transition: all 0.3s ease;
    }
    .btn-submit-premium:hover { opacity: 0.9; }

    .section-divider {
        grid-column: 1 / -1;
        font-size: 11px; font-weight: 800; color: var(--text-main);
        text-transform: uppercase;
        border-left: 3px solid var(--bml-pink);
        padding-left: 10px; margin: 15px 0;
    }
</style>
</head>

<body>
    <div class="floating-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="pendaftaran-card">
        <div class="header-section">
            <h2>Pendaftaran</h2>
            <p>Lengkapi formulir medis pasien baru untuk memulai pemantauan kehamilan terintegrasi.</p>
        </div>

        <form method="POST" action="{{ route('pendaftaran.store') }}">
            @csrf

            <div class="form-grid-3">
                <div class="form-group">
                    <label>NIK Pasien</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="form-input" placeholder="16 Digit Nomor KTP" maxlength="16" required>
                </div>

                <div class="form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-input" placeholder="08XXXXXXXXXX" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-input readonly-medis" value="{{ Auth::user()->name }}" disabled>
                    <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama" class="form-input" required>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-input" placeholder="Kota Kelahiran" required>
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan" class="form-input" required>
                        <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                        <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3 / Diploma</option>
                        <option value="S1/D4" {{ old('pendidikan') == 'S1/D4' ? 'selected' : '' }}>S1 / D4 / Sarjana</option>
                        <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir Ibu</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Golongan Darah</label>
                    <select name="gol_darah" class="form-input" required>
                        <option value="A" {{ old('gol_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('gol_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('gol_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('gol_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Umur Ibu</label>
                    <input type="number" id="umur" name="umur" value="{{ old('umur') }}" class="form-input readonly-medis" placeholder="Otomatis" readonly required>
                </div>

                <div class="form-group">
                    <label>Pekerjaan Ibu</label>
                    <select id="pekerjaan_select" class="form-input" required>
                        <option value="Ibu Rumah Tangga" {{ old('pekerjaan') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                        <option value="PNS / ASN" {{ old('pekerjaan') == 'PNS / ASN' ? 'selected' : '' }}>PNS / ASN</option>
                        <option value="Karyawan Swasta" {{ old('pekerjaan') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Lainnya">Lainnya...</option>
                    </select>
                    <div id="kotak_lainnya" class="hidden-pekerjaan">
                        <input type="text" id="input_manual" name="pekerjaan" value="{{ old('pekerjaan') }}" class="form-input" placeholder="Tulis Pekerjaan Anda" style="border-color: var(--bml-pink);">
                    </div>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Alamat Domisili Lengkap</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-input" placeholder="Nama Jalan, RT/RW, Desa, Kecamatan" required>
                </div>

                <div class="section-divider">Data Suami (Penanggung Jawab)</div>

                <div class="form-group">
                    <label>Nama Suami</label>
                    <input type="text" name="nama_suami" value="{{ old('nama_suami') }}" class="form-input" placeholder="Nama Ayah" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir Suami</label>
                    <input type="date" id="tgllahir_suami" name="tgllahir_suami" value="{{ old('tgllahir_suami') }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Umur Suami</label>
                    <input type="number" id="usia_suami" name="usia_suami" value="{{ old('usia_suami') }}" class="form-input readonly-medis" placeholder="Otomatis" readonly required>
                </div>

                <div class="kalkulator-medis-box">
                    <div class="form-group">
                        <label>HPHT (Hari Pertama Haid Terakhir)</label>
                        <input type="date" id="hpht" name="hpht" value="{{ old('hpht') }}" class="form-input" style="border-color: #F9A8D4;" required>
                    </div>

                    <div class="form-group">
                        <label>Estimasi Persalinan (HPL / EDD)</label>
                        <input type="date" id="hpl_screen" class="form-input readonly-medis" style="background-color: #FFF !important; color: #DB2777 !important; border-color: #F9A8D4 !important;" readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit-premium">
                Daftar 
            </button>
            <div style="clear: both;"></div>
        </form>
    </div>

    <script>
        const selPekerjaan = document.getElementById('pekerjaan_select');
        const boxLainnya = document.getElementById('kotak_lainnya');
        const inpManual = document.getElementById('input_manual');

        function togglePekerjaan() {
            if (selPekerjaan.value === 'Lainnya') {
                boxLainnya.style.display = 'block';
                inpManual.setAttribute('name', 'pekerjaan');
                selPekerjaan.removeAttribute('name');
            } else {
                boxLainnya.style.display = 'none';
                selPekerjaan.setAttribute('name', 'pekerjaan');
                inpManual.removeAttribute('name');
            }
        }
        selPekerjaan.addEventListener('change', togglePekerjaan);

        function calcAge(birthDate) {
            if (!birthDate) return '';
            const today = new Date();
            const birth = new Date(birthDate);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            return age < 0 ? 0 : age;
        }

        document.getElementById('tgl_lahir').addEventListener('change', function() {
            document.getElementById('umur').value = calcAge(this.value);
        });

        document.getElementById('tgllahir_suami').addEventListener('change', function() {
            document.getElementById('usia_suami').value = calcAge(this.value);
        });

        document.getElementById('hpht').addEventListener('change', function() {
            if (!this.value) return;
            let hpl = new Date(this.value);
            hpl.setDate(hpl.getDate() + 7);
            hpl.setMonth(hpl.getMonth() - 3);
            hpl.setFullYear(hpl.getFullYear() + 1);

            let y = hpl.getFullYear();
            let m = String(hpl.getMonth() + 1).padStart(2, '0');
            let d = String(hpl.getDate()).padStart(2, '0');
            document.getElementById('hpl_screen').value = `${y}-${m}-${d}`;
        });

        window.addEventListener('DOMContentLoaded', () => {
            if(document.getElementById('tgl_lahir').value) document.getElementById('umur').value = calcAge(document.getElementById('tgl_lahir').value);
            if(document.getElementById('tgllahir_suami').value) document.getElementById('usia_suami').value = calcAge(document.getElementById('tgllahir_suami').value);
            if(document.getElementById('hpht').value) document.getElementById('hpht').dispatchEvent(new Event('change'));
            
            const oldPek = "{{ old('pekerjaan') }}";
            if(oldPek && !['Ibu Rumah Tangga','PNS / ASN','Karyawan Swasta','Wiraswasta'].includes(oldPek)) {
                selPekerjaan.value = 'Lainnya';
                inpManual.value = oldPek;
            } else if(oldPek) {
                selPekerjaan.value = oldPek;
            }
            togglePekerjaan();
        });
    </script>
    @include('partials.alerts')

</body>
</html>