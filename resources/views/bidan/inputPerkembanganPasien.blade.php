@extends('layouts.masterBidan')

@section('content')
    <style>
        /* Kode CSS untuk mengubah warna header */
        .header-pink th {
            background-color: #f875aa !important; /* !important memastikan warna Bootstrap tertimpa */
            color: white !important;
        }
    </style>

<div class="container-fluid mb-5">
    <h3 class="fw-bold mb-4 text-dark">Input Rekam Medis Pasien</h3>
    @include('partials.alerts')

    <form action="{{ route('bidan.inputPerkembangan') }}" method="POST" id="formPerkembangan" 
          onsubmit="return validasiFormPerkembangan(event)" class="card shadow rounded-4 p-4 mb-4 border-0">
        @csrf
        <input type="hidden" name="pasien_id" value="{{ request()->get('pasien_id') ?? $pasien->id }}">

        <div class="card p-3 mb-4 border-0 bg-light rounded-3 shadow-sm">
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" name="is_persalinan" id="checkPersalinan" value="1" style="width: 45px; height: 23px; cursor:pointer;">
                <label class="form-check-label fw-bold text-dark ms-2 pt-1" for="checkPersalinan" style="cursor:pointer;">
                    Pasien Melahirkan Hari Ini? (Centang untuk membuka Form Laporan Persalinan)
                </label>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Data Pemeriksaan</h5>
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label fw-bold" id="labelTanggalPemeriksaan">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="form-control rounded-3" required>
            </div>
            <div class="col-md-4">
                 <label class="form-label">Waktu Pemeriksaan <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="time" name="waktu_pemeriksaan" class="form-control rounded-start-3" step="60" required>
                    <span class="input-group-text rounded-end-3">WIB</span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Pelayanan / Kunjungan <span class="text-danger">*</span></label>
                <select name="jenis_layanan" id="select_jenis_layanan" class="form-select rounded-3" required>
                    <option value="">-- Pilih Jenis Pelayanan --</option>
                    <option value="Kunjungan Pertama">Kunjungan Pertama</option>
                    <option value="Kunjungan Ulang">Kunjungan Ulang</option>
                    <option value="Persalinan">Persalinan</option>
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Data Kehamilan</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">HPHT <span class="text-danger">*</span></label>
                <input type="date" name="hpht" id="hpht" value="{{ old('hpht', $hpht ?? '') }}" class="form-control rounded-3" readonly required>
             </div>
            <div class="col-md-4">
                 <label class="form-label">HPL (Hari Perkiraan Lahir) <span class="text-danger">*</span></label>
                 <input type="date" name="hpl" id="hpl" class="form-control rounded-3" readonly required style="background-color: #e9ecef;">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Usia Kehamilan <span class="text-danger">*</span></label>
                <input type="text" name="usia_kehamilan" id="usia_kehamilan" class="form-control rounded-3" readonly required placeholder="Otomatis" style="background-color: #e9ecef;">
            </div>
            <div class="col-md-4">
                <label class="form-label">Trimester</label>
                <input type="number" name="trimester" id="select_trimester" class="form-control rounded-3" style="background-color: #e9ecef;" readonly required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kehamilan Ke- (Gravida) <span class="text-danger">*</span></label>
                <select name="kehamilan_ke" class="form-select rounded-3" required>
                    <option value="">-- Kehamilan Ke- --</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Riwayat Kesehatan</h5>
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Riwayat Penyakit <span class="text-danger">*</span></label>
                <input type="hidden" name="riwayat_penyakit" id="hidden_riwayat_penyakit" value="-">
                <select id="select_riwayat_penyakit" class="form-select mb-2 rounded-3" required>
                    <option value="-">-- Riwayat Penyakit --</option>
                    <option value="-">Tidak Ada (-)</option>
                    <option value="Hipertensi">Hipertensi</option>
                    <option value="Diabetes">Diabetes</option>
                    <option value="Jantung">Jantung</option>
                    <option value="Paru-Paru">Paru-Paru</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
                <div id="riwayat_manual_box" style="display:none;">
                    <input type="text" id="input_riwayat_penyakit" class="form-control rounded-3" placeholder="Tulis riwayat penyakit" required value="-">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Riwayat Alergi</label>
                <input type="text" name="riwayat_alergi" class="form-control rounded-3" placeholder="Tulis (-) jika tidak ada">
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Hasil Pemeriksaan Umum</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="berat_badan" id="berat_badan" class="form-control rounded-3" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="tinggi_badan" id="tinggi_badan" class="form-control rounded-3" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">IMT</label>
                <input type="number" step="0.01" min="0" name="imt" id="imt" class="form-control rounded-3" placeholder="Otomatis" readonly style="background-color: #e9ecef;" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Tekanan Darah (mmHg) <span class="text-danger">*</span></label>
                <input type="text" name="tekanan_darah" class="form-control rounded-3" placeholder="Contoh: 120/80" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tinggi Fundus Uteri (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="tinggi_fundus" class="form-control rounded-3" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">LILA (cm) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="lila" class="form-control rounded-3" placeholder="Contoh: 23.5" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Denyut Jantung Janin (DJJ) <span class="text-danger">*</span></label>
                <input type="number" min="0" name="djj" class="form-control rounded-3" placeholder="Contoh: 140" required>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Keluhan & Diagnosis <span class="text-danger">*</span></h5>
        <textarea name="keluhan" class="form-control mb-3 rounded-3" rows="3" placeholder="Tuliskan keluhan pasien" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Tindakan / Saran Bidan <span class="text-danger">*</span></h5>
        <textarea name="tindakan" class="form-control mb-3 rounded-3" rows="3" placeholder="Tuliskan saran atau tindakan" required></textarea>

        <h5 class="fw-bold text-pink mb-3">Obat yang Diberikan <span class="text-danger">*</span></h5>
        <textarea name="obat" class="form-control mb-4 rounded-3" rows="2" placeholder="Tuliskan obat yang diberikan" required></textarea>


        <div id="containerPersalinan" class="border p-4 rounded-4 mb-4 bg-white shadow-sm" style="display: none; border-color: #f875aa !important;">
            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                <i class="fas fa-baby text-pink fa-2x me-3"></i>
                <h4 class="fw-bold text-pink m-0">Laporan Persalinan</h4>
            </div>

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">1. Keadaan Umum Ibu Pasca Persalinan</h5>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Keadaan Umum Ibu <span class="text-danger">*</span></label>
                    <select name="keadaan_umum_ibu" class="form-select input-salin">
                        <option value="Baik">Baik</option>
                        <option value="Lemah">Lemah</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nadi (x/menit) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="nadi" class="form-control input-salin" placeholder="Misal: 84">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tekanan Darah Ibu (mmHg) <span class="text-danger">*</span></label>
                    <input type="text" name="tekanan_darah_ibu" class="form-control input-salin" placeholder="Contoh: 110/70">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kadar Hb (gr%) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="hb" class="form-control input-salin" placeholder="Contoh: 11.5">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Uterus (Kontraksi & TFU Pasca Salin) <span class="text-danger">*</span></label>
                    <input type="text" name="uterus_kontraksi_tfu" class="form-control input-salin" placeholder="Contoh: Kontraksi keras, TFU 2 jari dbw pusat">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Pendarahan Kala III (cc) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="pendarahan_kala_iii" class="form-control input-salin" placeholder="Contoh: 150">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Pendarahan Kala IV (cc) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="pendarahan_kala_iv" class="form-control input-salin" placeholder="Contoh: 50">
                </div>
            </div>

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">2. Kondisi Plasenta</h5>
            <div class="row mb-4">
               <div class="col-md-4 mb-3">
                    <label class="form-label">Bentuk / Ukuran Plasenta <span class="text-danger">*</span></label>
                        <select name="plasenta_bentuk_ukuran" id="select_bentuk_plasenta" class="form-select mb-2">
                        <option value="Lengkap / Normal">Lengkap / Normal</option>
                        <option value="Tidak Lengkap (Robek/Tertinggal Sebagian)">Tidak Lengkap (Robek/Tertinggal Sebagian)</option>
                        <option value="Ukuran Kecil / Tipis">Ukuran Kecil / Tipis</option>
                        </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tali Pusat</label>
                   <select name="plasenta_tali_pusat" id="select_tali_pusat" class="form-select mb-2">
        <option value="Normal">Normal (±50-60 cm, Pembuluh Darah Lengkap)</option>
        <option value="Lilitan Tali Pusat">Lilitan Tali Pusat</option>
        <option value="Simpul Tali Pusat">Simpul Tali Pusat (True/False Knot)</option>
        <option value="Kelainan Insersi (Battledore/Velamentosa)">Kelainan Insersi (Battledore/Velamentosa)</option>
    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kulit Ketuban</label>
                    <select name="plasenta_kulit_ketuban" class="form-select" required>
                    <option value="Utuh">Utuh (Lengkap)</option>
                    <option value="Robek">Robek (Sisa/Tidak Lengkap)</option>
                    </select>
                </div>
            </div>

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">3. Identitas & Kondisi Anak</h5>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jenis Kelamin Bayi <span class="text-danger">*</span></label>
                    <select name="anak_jenis_kelamin" class="form-select input-salin">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kondisi Lahir <span class="text-danger">*</span></label>
                    <select name="anak_kondisi_lahir" id="select_kondisi_lahir" class="form-select input-salin">
                        <option value="Hidup">Hidup</option>
                        <option value="Mati">Mati</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Berat Badan (Kg) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="anak_berat_badan" class="form-control input-salin" placeholder="Contoh: 3.2">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Panjang Badan (cm) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="anak_panjang_badan" class="form-control input-salin" placeholder="Contoh: 50">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Lingkar Dada (cm) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="anak_lingkar_dada" class="form-control input-salin" placeholder="Contoh: 33">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Lingkar Kepala (cm) <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="anak_lingkar_kepala" class="form-control input-salin" placeholder="Contoh: 34">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelainan Kongenital <span class="text-danger">*</span></label>
                    <select id="select_kelainan" class="form-select mb-2">
                        <option value="-">Tidak Ada (-)</option>
                        <option value="Anensefali">Anensefali</option>
                        <option value="Bibir Sumbing">Bibir Sumbing</option>
                        <option value="Atresia Ani">Atresia Ani</option>
                        <option value="Lainnya">Lainnya...</option>
                    </select>
                    <input type="hidden" name="anak_kelainan_kongenital" id="hidden_kelainan" value="-">
                    <input type="text" id="input_manual_kelainan" class="form-control rounded-3" style="display:none;" placeholder="Sebutkan kelainan kongenital bayi">
                </div>
            </div>
            
            <div class="row mb-4 p-2 bg-light rounded-3 border mx-0" id="boxBayiMati" style="display:none;">
                <div class="col-md-6">
                    <label class="form-label">Meninggal setelah lahir (menit post partum)</label>
                    <input type="number" min="0" name="bayi_meninggal_menit_post_partum" class="form-control" placeholder="Contoh: 5">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sebab Kematian Bayi</label>
                    <input type="text" name="bayi_mati_sebab" class="form-control" placeholder="Sebab kematian">
                </div>
            </div>

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">4. Penilaian Tabel APGAR SCORE</h5>
            <div class="table-responsive mb-4">
               <table class="table table-bordered table-striped text-center align-middle" style="font-size: 13px;">
    <thead class="header-pink">
        <tr>
            <th width="8%">Waktu</th>
            <th width="12%">Tanda</th>
            <th width="23%">Skor 0</th>
            <th width="23%">Skor 1</th>
            <th width="23%">Skor 2</th>
            <th width="11%">Nilai Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="5" class="fw-bold bg-light">Menit 1</td>
            <td class="text-start fw-bold">Frek. Jantung</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_jantung" value="0" class="form-check-input apgar-m1" checked> <label class="form-check-label">Tak ada</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_jantung" value="1" class="form-check-input apgar-m1"> <label class="form-check-label">&lt; 100</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_jantung" value="2" class="form-check-input apgar-m1"> <label class="form-check-label">&gt; 100</label></div></td>
            <td rowspan="5" class="fw-bold fs-5 text-primary bg-light" id="total_apgar_m1">0</td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Usaha Napas</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_napas" value="0" class="form-check-input apgar-m1" checked> <label class="form-check-label">Tak ada</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_napas" value="1" class="form-check-input apgar-m1"> <label class="form-check-label">Lambat / Tak teratur</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_napas" value="2" class="form-check-input apgar-m1"> <label class="form-check-label">Menangis kuat</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Tonus Otot</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_otot" value="0" class="form-check-input apgar-m1" checked> <label class="form-check-label">Lumpuh</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_otot" value="1" class="form-check-input apgar-m1"> <label class="form-check-label">Ekstremitas fleksi sedikit</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_otot" value="2" class="form-check-input apgar-m1"> <label class="form-check-label">Gerakan aktif</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Refleks</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_refleks" value="0" class="form-check-input apgar-m1" checked> <label class="form-check-label">Tak bereaksi</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_refleks" value="1" class="form-check-input apgar-m1"> <label class="form-check-label">Gerakan sedikit</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_refleks" value="2" class="form-check-input apgar-m1"> <label class="form-check-label">Menangis / Bersin</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Warna Kulit</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_warna" value="0" class="form-check-input apgar-m1" checked> <label class="form-check-label">Biru / Pucat</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_warna" value="1" class="form-check-input apgar-m1"> <label class="form-check-label">Tubuh kemerahan, kaki biru</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m1_warna" value="2" class="form-check-input apgar-m1"> <label class="form-check-label">Kemerahan seluruhnya</label></div></td>
        </tr>

        <tr>
            <td rowspan="5" class="fw-bold bg-light">Menit 5</td>
            <td class="text-start fw-bold">Frek. Jantung</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_jantung" value="0" class="form-check-input apgar-m5" checked> <label class="form-check-label">Tak ada</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_jantung" value="1" class="form-check-input apgar-m5"> <label class="form-check-label">&lt; 100</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_jantung" value="2" class="form-check-input apgar-m5"> <label class="form-check-label">&gt; 100</label></div></td>
            <td rowspan="5" class="fw-bold fs-5 text-success bg-light" id="total_apgar_m5">0</td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Usaha Napas</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_napas" value="0" class="form-check-input apgar-m5" checked> <label class="form-check-label">Tak ada</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_napas" value="1" class="form-check-input apgar-m5"> <label class="form-check-label">Lambat / Tak teratur</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_napas" value="2" class="form-check-input apgar-m5"> <label class="form-check-label">Menangis kuat</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Tonus Otot</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_otot" value="0" class="form-check-input apgar-m5" checked> <label class="form-check-label">Lumpuh</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_otot" value="1" class="form-check-input apgar-m5"> <label class="form-check-label">Ekstremitas fleksi sedikit</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_otot" value="2" class="form-check-input apgar-m5"> <label class="form-check-label">Gerakan aktif</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Refleks</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_refleks" value="0" class="form-check-input apgar-m5" checked> <label class="form-check-label">Tak bereaksi</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_refleks" value="1" class="form-check-input apgar-m5"> <label class="form-check-label">Gerakan sedikit</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_refleks" value="2" class="form-check-input apgar-m5"> <label class="form-check-label">Menangis / Bersin</label></div></td>
        </tr>
        <tr>
            <td class="text-start fw-bold">Warna Kulit</td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_warna" value="0" class="form-check-input apgar-m5" checked> <label class="form-check-label">Biru / Pucat</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_warna" value="1" class="form-check-input apgar-m5"> <label class="form-check-label">Tubuh kemerahan, kaki biru</label></div></td>
            <td class="text-start"><div class="form-check"><input type="radio" name="apgar_m5_warna" value="2" class="form-check-input apgar-m5"> <label class="form-check-label">Kemerahan seluruhnya</label></div></td>
        </tr>
    </tbody>
</table>
            </div>

            <input type="hidden" name="apgar_m1_total" id="hidden_apgar_m1" value="0">
            <input type="hidden" name="apgar_m5_total" id="hidden_apgar_m5" value="0">

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">5. Tindakan Resusitasi</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">O2 di muka mulut</label>
                    <input type="text" name="resusitasi_o2" class="form-control" placeholder="Contoh: 2 mnt s/d 5 mnt sesudah lahir">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pompa udara berulang</label>
                    <input type="text" name="resusitasi_pompa_udara" class="form-control" placeholder="Menit sesudah lahir">
                </div>
            </div>

            <h5 class="fw-bold text-dark border-start border-4 border-pink ps-2 mb-3">6. Ikhtisar Jalannya Persalinan</h5>
            <div class="row mb-3">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Ketuban Pecah Tanggal</label>
                    <input type="date" name="ketuban_pecah_tgl" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Ketuban Pecah Jam</label>
                    <input type="time" name="ketuban_pecah_jam" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Bayi Lahir Tanggal</label>
                    <input type="date" name="bayi_lahir_tgl" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Bayi Lahir Jam</label>
                    <input type="time" name="bayi_lahir_jam" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Macam Persalinan <span class="text-danger">*</span></label>
                    <select name="macam_persalinan" id="select_macam_persalinan" class="form-select mb-2">
                        <option value="Normal Spontan (Letak Belakang Kepala)">Normal Spontan (Letak Belakang Kepala)</option>
                        <option value="Normal Spontan (Letak Sungsang / Darurat)">Normal Spontan (Letak Sungsang / Darurat)</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Indikasi Persalinan</label>
                    <select name="indikasi_persalinan" class="form-select">
                        <option value="">-- Pilih Indikasi Persalinan --</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                        <option value="Ketuban Pecah Dini">Ketuban Pecah Dini</option>
                        <option value="Kontraksi Teratur">Kontraksi Teratur</option>
                        </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Lama Persalinan (Jam)</label>
                    <input type="text" name="lama_persalinan_jam" class="form-control" placeholder="Contoh: 8 Jam">
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-pink mb-3">Catatan Tambahan</h5>
        <textarea name="catatan_tambahan" class="form-control mb-4 rounded-3" rows="3" placeholder="Catatan tambahan gabungan rekam medis (Opsional)"></textarea>

        <div class="row align-items-center bg-light p-3 rounded-4 border mx-0 mb-4">
            <div class="col-md-8">
                <label class="form-label fw-bold text-dark">Bidan Penanggung Jawab</label>
                <input type="text" class="form-control bg-white fw-bold text-secondary" value="Siti Fatimah, S.Tr.Keb." readonly style="cursor: not-allowed; max-width: 400px;">
                <small class="text-muted d-block mt-1">*Nama terkunci otomatis sebagai penanggung jawab rekam medis.</small>
            </div>
            <div class="col-md-4 text-center border-start">
                <label class="form-label d-block fw-bold mb-2">Verifikasi TTD Elektronik</label>
                <div class="p-3 bg-white border border-dashed rounded-3 d-inline-block shadow-sm">
                    <i class="fas fa-qrcode fa-3x text-muted mb-1"></i>
                    <span class="d-block text-success fw-bold" style="font-size:11px;"><i class="fas fa-check-circle"></i> QR Code Otomatis Aktif</span>
                </div>
            </div>
        </div>

        <div class="text-end gap-2 d-flex justify-content-end">
            @if(request()->query('pasien_id'))
                <a href="{{ route('bidan.inputDaftarPasien', ['id' => request()->query('pasien_id')]) }}" class="btn btn-secondary rounded-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            @else
                <a href="{{ route('bidan.daftarPasien') }}" class="btn btn-secondary rounded-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            @endif

            <button type="reset" class="btn btn-warning text-dark rounded-3" id="btnResetForm">
                <i class="fas fa-undo me-1"></i> Reset
            </button>
            
            <button type="submit" class="btn text-white rounded-3" style="background-color:#f875aa;">
                <i class="fas fa-save me-1"></i> Simpan Rekam Medis
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkPersalinan = document.getElementById('checkPersalinan');
    const containerPersalinan = document.getElementById('containerPersalinan');
    const labelTanggal = document.getElementById('labelTanggalPemeriksaan');
    const inputsSalin = document.querySelectorAll('.input-salin');
    const selectJenisLayanan = document.getElementById('select_jenis_layanan');

    // ==========================================
    // DYNAMIC SWITCH LABEL & VISIBILITY
    // ==========================================
    if (checkPersalinan) {
        checkPersalinan.addEventListener('change', function() {
            if (this.checked) {
                if (containerPersalinan) containerPersalinan.style.display = 'block';
                if (labelTanggal) labelTanggal.innerHTML = 'Tanggal Persalinan <span class="text-danger">*</span>';
                inputsSalin.forEach(input => input.required = true);
                if (selectJenisLayanan) selectJenisLayanan.value = 'Persalinan';
            } else {
                if (containerPersalinan) containerPersalinan.style.display = 'none';
                if (labelTanggal) labelTanggal.innerHTML = 'Tanggal Pemeriksaan <span class="text-danger">*</span>';
                inputsSalin.forEach(input => input.required = false);
            }
        });
    }

    // ==========================================
    // SELECTION DYNAMIC (LAINNYA SELECT BOX)
    // ==========================================
    // 1. Kelainan Kongenital
    const selectKelainan = document.getElementById('select_kelainan');
    const inputManualKelainan = document.getElementById('input_manual_kelainan');
    const hiddenKelainan = document.getElementById('hidden_kelainan');

    if (selectKelainan && inputManualKelainan && hiddenKelainan) {
        selectKelainan.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                inputManualKelainan.style.display = 'block';
                inputManualKelainan.required = true;
                inputManualKelainan.value = '';
                hiddenKelainan.value = '';
            } else {
                inputManualKelainan.style.display = 'none';
                inputManualKelainan.required = false;
                hiddenKelainan.value = this.value;
            }
        });
        inputManualKelainan.addEventListener('input', function() {
            hiddenKelainan.value = this.value;
        });
    }

    // 2. Macam Persalinan
    const selectMacam = document.getElementById('select_macam_persalinan');
    const inputManualMacam = document.getElementById('input_manual_macam');
    const hiddenMacam = document.getElementById('hidden_macam_persalinan');

    if (selectMacam && inputManualMacam && hiddenMacam) {
        selectMacam.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                inputManualMacam.style.display = 'block';
                inputManualMacam.required = true;
                inputManualMacam.value = '';
                hiddenMacam.value = '';
            } else {
                inputManualMacam.style.display = 'none';
                inputManualMacam.required = false;
                hiddenMacam.value = this.value;
            }
        });
        inputManualMacam.addEventListener('input', function() {
            hiddenMacam.value = this.value;
        });
    }

    // ==========================================
    // PREVENT NEGATIVE VALUE ON NUMBER INPUTS
    // ==========================================
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === 'e') {
                e.preventDefault();
            }
        });
        input.addEventListener('input', function() {
            if (this.value < 0) this.value = 0;
        });
    });

    // ==========================================
    // AUTO KALKULASI APGAR SCORE
    // ==========================================
    function hitungApgarM1() {
        let total = 0;
        const radios = document.querySelectorAll('.apgar-m1:checked');
        if (radios.length === 0) return;
        radios.forEach(radio => { total += parseInt(radio.value); });
        
        const elTotal = document.getElementById('total_apgar_m1');
        const elHidden = document.getElementById('hidden_apgar_m1');
        if (elTotal) elTotal.textContent = total;
        if (elHidden) elHidden.value = total;
    }

    function hitungApgarM5() {
        let total = 0;
        const radios = document.querySelectorAll('.apgar-m5:checked');
        if (radios.length === 0) return;
        radios.forEach(radio => { total += parseInt(radio.value); });

        const elTotal = document.getElementById('total_apgar_m5');
        const elHidden = document.getElementById('hidden_apgar_m5');
        if (elTotal) elTotal.textContent = total;
        if (elHidden) elHidden.value = total;
    }

    document.querySelectorAll('.apgar-m1').forEach(radio => radio.addEventListener('change', hitungApgarM1));
    document.querySelectorAll('.apgar-m5').forEach(radio => radio.addEventListener('change', hitungApgarM5));

    // ==========================================
    // LOGIK DATA KEHAMILAN (HPHT & IMT)
    // ==========================================
    const inputHpht = document.getElementById('hpht');
    const inputHpl = document.getElementById('hpl');
    const inputUsia = document.getElementById('usia_kehamilan');
    const inputTanggalPeriksa = document.getElementById('tanggal_pemeriksaan');
    const inputTrimester = document.getElementById('select_trimester');

    if (inputTanggalPeriksa && !inputTanggalPeriksa.value) {
        inputTanggalPeriksa.value = new Date().toISOString().split('T')[0];
    }

    function hitungOtomatisKehamilan() {
        const hphtValue = inputHpht ? inputHpht.value : '';
        const tglPeriksaValue = inputTanggalPeriksa ? inputTanggalPeriksa.value : '';
        if (!hphtValue || !tglPeriksaValue) return;

        const dateHpht = new Date(hphtValue);
        const datePeriksa = new Date(tglPeriksaValue);
        
        // Rumus Negele untuk perkiraan lahir HPL
        const dateHpl = new Date(dateHpht);
        dateHpl.setDate(dateHpl.getDate() + 7);
        dateHpl.setMonth(dateHpl.getMonth() + 9); 
        
        if (inputHpl) inputHpl.value = dateHpl.toISOString().split('T')[0];

        // Hitung Usia Kehamilan & Trimester
        const selisihWaktu = datePeriksa.getTime() - dateHpht.getTime();
        const selisihHari = Math.floor(selisihWaktu / (1000 * 3600 * 24));
        
        if (selisihHari >= 0) {
            const minggu = Math.floor(selisihHari / 7);
            const hari = selisihHari % 7;
            if (inputUsia) inputUsia.value = `${minggu} Minggu ${hari} Hari`;
            if (inputTrimester) {
                if (minggu >= 0 && minggu <= 13) inputTrimester.value = 1;
                else if (minggu >= 14 && minggu <= 27) inputTrimester.value = 2;
                else if (minggu >= 28 && minggu <= 42) inputTrimester.value = 3;
            }
        }
    }

    if (inputHpht) inputHpht.addEventListener('change', hitungOtomatisKehamilan);
    if (inputTanggalPeriksa) inputTanggalPeriksa.addEventListener('change', hitungOtomatisKehamilan);

    // ==========================================
    // AUTO KALKULASI IMT
    // ==========================================
    const inputBB = document.getElementById('berat_badan');
    const inputTB = document.getElementById('tinggi_badan');
    const inputIMT = document.getElementById('imt');

    function hitungIMT() {
        if (!inputBB || !inputTB || !inputIMT) return;
        const bb = parseFloat(inputBB.value);
        const tb = parseFloat(inputTB.value) / 100;
        if (bb > 0 && tb > 0) {
            inputIMT.value = (bb / (tb * tb)).toFixed(2);
        } else {
            inputIMT.value = '';
        }
    }
    if (inputBB && inputTB) {
        inputBB.addEventListener('input', hitungIMT);
        inputTB.addEventListener('input', hitungIMT);
    }

    // Penyakit manual box handler
// Penyakit manual box handler
const selectPenyakit = document.getElementById('select_riwayat_penyakit');
const boxManual = document.getElementById('riwayat_manual_box');
const inputManualPenyakit = document.getElementById('input_riwayat_penyakit');

if (selectPenyakit && boxManual && inputManualPenyakit) {
    selectPenyakit.addEventListener('change', function() {
        if (this.value === 'Lainnya') {
            boxManual.style.display = 'block';
            inputManualPenyakit.required = true;
            inputManualPenyakit.value = '';
            // Kosongkan name dari select agar tidak bentrok
            selectPenyakit.removeAttribute('name');
            inputManualPenyakit.setAttribute('name', 'riwayat_penyakit');
        } else {
            boxManual.style.display = 'none';
            inputManualPenyakit.required = false;
            // Kembalikan name ke select
            selectPenyakit.setAttribute('name', 'riwayat_penyakit');
            inputManualPenyakit.removeAttribute('name');
        }
    });
}
    // Reset Form Handler
    const btnReset = document.getElementById('btnResetForm');
    if (btnReset) {
        btnReset.addEventListener('click', function() {
            setTimeout(() => {
                hitungIMT();
                hitungApgarM1();
                hitungApgarM5();
                if (containerPersalinan) containerPersalinan.style.display = 'none';
                if (labelTanggal) labelTanggal.innerHTML = 'Tanggal Pemeriksaan <span class="text-danger">*</span>';
                if (inputManualKelainan) inputManualKelainan.style.display = 'none';
                if (inputManualMacam) inputManualMacam.style.display = 'none';
            }, 20);
        });
    }

    // JALANKAN KALKULASI OTOMATIS SAAT HALAMAN SELESAI DI-LOAD
    hitungOtomatisKehamilan();
    hitungIMT();
    hitungApgarM1();
    hitungApgarM5();
});

// VALIDASI FINAL SEBELUM SUBMIT
window.validasiFormPerkembangan = function(event) {
    const form = document.getElementById('formPerkembangan');
    const checkPersalinan = document.getElementById('checkPersalinan');
    const isPersalinanActive = checkPersalinan ? checkPersalinan.checked : false;
    
    let kolomWajib = [
        'tanggal_pemeriksaan','waktu_pemeriksaan','usia_kehamilan',
        'trimester','kehamilan_ke','berat_badan','tinggi_badan',
        'imt','tekanan_darah','tinggi_fundus','lila','djj','keluhan','jenis_layanan'
    ];

    if (isPersalinanActive) {
        kolomWajib.push(
            'keadaan_umum_ibu', 'nadi', 'tekanan_darah_ibu', 'hb', 
            'uterus_kontraksi_tfu', 'pendarahan_kala_iii', 'pendarahan_kala_iv',
            'anak_jenis_kelamin', 'anak_kondisi_lahir', 'anak_berat_badan', 
            'anak_panjang_badan', 'anak_lingkar_dada', 'anak_lingkar_kepala',
            'macam_persalinan', 'anak_kelainan_kongenital'
        );
    }

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
        alert("Mohon periksa kembali! Seluruh kolom dengan tanda bintang (*) wajib terisi.");
        return false;
    }
    return true;
};
</script>
@endsection