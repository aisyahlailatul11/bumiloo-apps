<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkembangan;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Persalinan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import ini untuk membuat kode QR acak
use Carbon\Carbon;

class PerkembanganController extends Controller
{
    public function cekKunjungan($pasien_id)
    {
        $total = Perkembangan::where('pasien_id', $pasien_id)->count();
        return response()->json(['total_kunjungan' => $total]);
    }

    public function indexPerkembangan(Request $request)
    {
        $pasien_id = $request->get('pasien_id') ?? $request->route('pasien_id');
        
        if (!$pasien_id && $request->headers->get('referer')) {
            $referer = $request->headers->get('referer');
            $segments = explode('/', trim(parse_url($referer, PHP_URL_PATH), '/'));
            $pasien_id = end($segments);
        }

        if (!$pasien_id || !is_numeric($pasien_id)) {
            return redirect()->route('bidan.daftarPasien')->with('error', 'ID Pasien tidak valid.');
        }

        $pasien = Pasien::findOrFail($pasien_id);

        $pendaftaran = DB::table('pasien')
            ->join('tb_pendaftaran', 'pasien.nik', '=', 'tb_pendaftaran.nik')
            ->where('pasien.id', $pasien_id)
            ->select('tb_pendaftaran.hpht')
            ->first();

        $hpht = $pendaftaran ? $pendaftaran->hpht : null;

        $perkembanganTerakhir = Perkembangan::where('pasien_id', $pasien_id)->latest()->first();
        if ($perkembanganTerakhir && $perkembanganTerakhir->hpht) {
            $hpht = $perkembanganTerakhir->hpht;
        }

        if ($hpht) {
            $hpht = \Carbon\Carbon::parse($hpht)->format('Y-m-d');
        }

        return view('bidan.inputPerkembanganPasien', compact('pasien', 'hpht'));
    }

    public function storePerkembangan(Request $request)
    {
        // 1. Validasi Utama dengan proteksi anti-angka negatif (min:0)
        $rules = [
            'pasien_id'           => 'required',
            'tanggal_pemeriksaan' => 'required|date',
            'waktu_pemeriksaan'   => 'required',
            'hpht'                => 'required|date',
            'hpl'                 => 'required|date',
            'usia_kehamilan'      => 'required|string',
            'trimester'           => 'required|numeric|in:1,2,3',
            'kehamilan_ke'        => 'required|numeric|min:0',
            'berat_badan'         => 'required|numeric|min:0',
            'tinggi_badan'        => 'required|numeric|min:0',
            'tekanan_darah'       => 'required|string',
            'riwayat_penyakit'    => 'required|string',
            'riwayat_alergi'      => 'required|string',
            'imt'                 => 'required|numeric|min:0',
            'lila'                => 'required|numeric|between:10,99.99',
            'tinggi_fundus'       => 'required|numeric|min:0',
            'djj'                 => 'required|numeric|min:0',
            'keluhan'             => 'required|string',
            'tindakan'            => 'required|string',
            'obat'                => 'required|string',
            'catatan_tambahan'    => 'nullable|string',
            'jenis_layanan'       => 'required|string',
        ];

        // 2. Validasi Tambahan Persalinan dengan proteksi anti-angka negatif (min:0)
        if ($request->has('is_persalinan')) {
            $rules += [
                'keadaan_umum_ibu'      => 'required|in:Baik,Lemah',
                'nadi'                  => 'required|numeric|min:0',
                'tekanan_darah_ibu'     => 'required|string',
                'hb'                    => 'required|numeric|min:0',
                'uterus_kontraksi_tfu'  => 'required|string',
                'pendarahan_kala_iii'   => 'required|numeric|min:0',
                'pendarahan_kala_iv'    => 'required|numeric|min:0',
                'anak_jenis_kelamin'    => 'required|in:Laki-Laki,Perempuan',
                'anak_kondisi_lahir'    => 'required|in:Hidup,Mati',
                'anak_berat_badan'      => 'required|numeric|min:0',
                'anak_panjang_badan'    => 'required|numeric|min:0',
                'anak_lingkar_dada'     => 'required|numeric|min:0',
                'anak_lingkar_kepala'   => 'required|numeric|min:0',
                'macam_persalinan'      => 'required|string',
                'anak_kelainan_kongenital' => 'required|string',
            ];
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            // A. Simpan Tabel Perkembangan
            $dataPerkembangan = $request->only([
                'pasien_id', 'tanggal_pemeriksaan', 'waktu_pemeriksaan', 'hpht', 'hpl',
                'usia_kehamilan', 'trimester', 'kehamilan_ke', 'berat_badan', 'tinggi_badan',
                'tekanan_darah', 'riwayat_penyakit', 'riwayat_alergi', 'imt', 'lila',
                'tinggi_fundus', 'djj', 'keluhan', 'tindakan', 'obat', 'catatan_tambahan', 'jenis_layanan'
            ]);
            
            $perkembangan = Perkembangan::create($dataPerkembangan);

            // B. Simpan Tabel Persalinan jika Checklist Aktif
            if ($request->has('is_persalinan')) {
                
                // Membuat kode token unik untuk kebutuhan TTD QR Code digital bidan
                $tokenTtdUrl = 'VALID-RM-' . $perkembangan->id . '-' . date('Ymd') . '-' . Str::random(6);

                Persalinan::create([
                    'perkembangan_id'       => $perkembangan->id,
                    'pasien_id'             => $request->pasien_id,
                    'tanggal_persalinan'    => $request->tanggal_pemeriksaan, // Masuk ke tabel persalinan sesuai tgl periksa
                    'keadaan_umum_ibu'      => $request->keadaan_umum_ibu,
                    'nadi'                  => $request->nadi,
                    'tekanan_darah'         => $request->tekanan_darah_ibu,
                    'hb'                    => $request->hb,
                    'uterus_kontraksi_tfu'  => $request->uterus_kontraksi_tfu,
                    'pendarahan_kala_iii'   => $request->pendarahan_kala_iii,
                    'pendarahan_kala_iv'    => $request->pendarahan_kala_iv,
                    'plasenta_bentuk_ukuran'=> $request->plasenta_bentuk_ukuran,
                    'plasenta_tali_pusat'   => $request->plasenta_tali_pusat,
                    'plasenta_kulit_ketuban'=> $request->plasenta_kulit_ketuban,
                    'anak_jenis_kelamin'    => $request->anak_jenis_kelamin,
                    'anak_kondisi_lahir'    => $request->anak_kondisi_lahir,
                    'anak_berat_badan'      => $request->anak_berat_badan,
                    'anak_panjang_badan'    => $request->anak_panjang_badan,
                    'anak_lingkar_dada'     => $request->anak_lingkar_dada,
                    'anak_lingkar_kepala'   => $request->anak_lingkar_kepala,
                    'anak_kelainan_kongenital'=> $request->anak_kelainan_kongenital,
                    'bayi_meninggal_menit_post_partum' => $request->bayi_meninggal_menit_post_partum,
                    'bayi_mati_sebab'       => $request->bayi_mati_sebab,
                    
                    'apgar_m1_jantung'      => $request->apgar_m1_jantung ?? 0,
                    'apgar_m1_napas'        => $request->apgar_m1_napas ?? 0,
                    'apgar_m1_otot'         => $request->apgar_m1_otot ?? 0,
                    'apgar_m1_refleks'      => $request->apgar_m1_refleks ?? 0,
                    'apgar_m1_warna'        => $request->apgar_m1_warna ?? 0,
                    'apgar_m1_total'        => $request->apgar_m1_total ?? 0,

                    'apgar_m5_jantung'      => $request->apgar_m5_jantung ?? 0,
                    'apgar_m5_napas'        => $request->apgar_m5_napas ?? 0,
                    'apgar_m5_otot'         => $request->apgar_m5_otot ?? 0,
                    'apgar_m5_refleks'      => $request->apgar_m5_refleks ?? 0,
                    'apgar_m5_warna'        => $request->apgar_m5_warna ?? 0,
                    'apgar_m5_total'        => $request->apgar_m5_total ?? 0,

                    'resusitasi_o2'           => $request->resusitasi_o2,
                    'resusitasi_pompa_udara'  => $request->resusitasi_pompa_udara,

                    'ketuban_pecah_at'      => $request->ketuban_pecah_tgl && $request->ketuban_pecah_jam ? Carbon::parse($request->ketuban_pecah_tgl . ' ' . $request->ketuban_pecah_jam) : null,
                    'bayi_lahir_at'         => $request->bayi_lahir_tgl && $request->bayi_lahir_jam ? Carbon::parse($request->bayi_lahir_tgl . ' ' . $request->bayi_lahir_jam) : null,
                    'macam_persalinan'      => $request->macam_persalinan,
                    'indikasi_persalinan'   => $request->indikasi_persalinan,
                    'lama_persalinan_jam'   => $request->lama_persalinan_jam,
                    
                    'nama_bidan'            => 'Siti Fatimah, S.Tr.Keb.', // Terisi otomatis dan permanen
                    'qr_signature_code'     => $tokenTtdUrl
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Seluruh data rekam medis berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage());
        }
    }
}