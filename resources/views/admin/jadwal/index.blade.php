@extends('layouts.masterAdmin')

@section('title', 'Jadwal Konsultasi - Bumiloo')

@section('content')
<style>
    .jwl-container * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box !important; }
    .jwl-form-box { background: #FFFFFF !important; border-radius: 24px !important; border: 1px solid #F1F5F9 !important; padding: 30px !important; width: 100% !important; box-shadow: 0 4px 25px rgba(0,0,0,0.01) !important; }
    
    /* Desain Baris Form Sejajar Pas Sesuai Urutan Baru */
    .jwl-form-row { display: flex; gap: 24px; width: 100%; margin-bottom: 20px; flex-wrap: wrap; }
    .jwl-form-group { display: flex; align-items: center; gap: 15px; flex: 1; min-width: 280px; }
    
    .jwl-label { font-size: 14px !important; font-weight: 600 !important; color: #1E293B !important; width: 120px !important; flex-shrink: 0 !important; }
    .jwl-input { background: #FFFFFF !important; border: 1px solid #CBD5E1 !important; border-radius: 10px !important; padding: 10px 16px !important; font-size: 14px !important; outline: none !important; width: 100%; height: 42px !important; }
    .jwl-input:focus { border-color: #F84F8F !important; box-shadow: 0 0 0 3px rgba(248, 79, 143, 0.1) !important; }
    
    .jwl-input-readonly { background-color: #F8FAFC !important; border-color: #E2E8F0 !important; color: #475569 !important; cursor: not-allowed !important; font-weight: 500 !important; }
    
    .jwl-btn-submit { background-color: #F84F8F !important; color: white !important; font-weight: bold !important; border-radius: 10px !important; padding: 12px 28px !important; border: none !important; cursor: pointer !important; font-size: 14px !important; display: inline-flex !important; align-items: center !important; gap: 10px !important; transition: 0.2s !important; }
    .jwl-btn-submit:hover { background-color: #e03e7a !important; }
}
</style>

<div class="jwl-container w-full" style="padding: 10px 20px; background-color: #FAFAFA; min-height: 100vh;">
    
    <h1 style="font-size: 28px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Jadwal Konsultasi Pasien</h1>

    <div class="jwl-form-box" style="margin-bottom: 35px;">
        <p style="font-size: 15px; font-weight: 700; color: #0F172A; margin: 0 0 25px 0;">
            {{ isset($editJadwal) ? 'Edit Atur Jadwal' : 'Form Pembuatan Jadwal Baru' }}
        </p>

        <form action="{{ isset($editJadwal) ? route('jadwal.update', $editJadwal->id) : route('jadwal.store') }}" method="POST" style="margin: 0; display: flex; flex-direction: column; width: 100%;">
            @csrf
            @if(isset($editJadwal)) 
            @method('PUT') 
            @endif

            <div class="jwl-form-row">
                <div class="jwl-form-group">
                    <label class="jwl-label">Nama Pasien</label>
                    <input type="text" name="nama" value="{{ $pasienTerpilih->nama_pasien ?? ($pasienTerpilih->nama ?? ($editJadwal->nama_pasien ?? '')) }}" readonly class="jwl-input jwl-input-readonly">
                </div>
                <div class="jwl-form-group">
                    <label class="jwl-label">NIK</label>
                    <input type="text" name="nik" value="{{ $pasienTerpilih->nik ?? ($editJadwal->nik ?? '') }}" readonly class="jwl-input jwl-input-readonly">
                </div>
            </div>

            <div class="jwl-form-row">
                <div class="jwl-form-group">
                    <label class="jwl-label">Tanggal Lahir</label>
                    <input type="text" name="tgl_lahir" value="{{ (isset($pasienTerpilih) && $pasienTerpilih->tgl_lahir) ? date('d/m/Y', strtotime($pasienTerpilih->tgl_lahir)) : ((isset($editJadwal) && $editJadwal->tgl_lahir) ? date('d/m/Y', strtotime($editJadwal->tgl_lahir)) : '') }}" readonly class="jwl-input jwl-input-readonly">
                </div>
                <div class="jwl-form-group">
                    <label class="jwl-label">No. HP</label>
                    <input type="text" name="no_hp" value="{{ $pasienTerpilih->no_hp ?? ($editJadwal->no_hp ?? '') }}" readonly class="jwl-input jwl-input-readonly">
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #F1F5F9; margin: 10px 0 25px 0;">

            <div class="jwl-form-row">
                <div class="jwl-form-group">
                    <label class="jwl-label">Tgl Pemeriksaan</label>
                    <input type="date" name="tgl_pemeriksaan" value="{{ $editJadwal->tgl_pemeriksaan ?? '' }}" required class="jwl-input">
                </div>
                <div class="jwl-form-group">
                    <label class="jwl-label">Jam</label>
                    <input type="time" name="jam" value="{{ $editJadwal->jam ?? '' }}" required class="jwl-input">
                </div>
            </div>

            <div class="jwl-form-row" style="margin-bottom: 25px;">
                <div class="jwl-form-group" style="align-items: flex-start;">
                    <label class="jwl-label" style="padding-top: 10px;">Keterangan</label>
                    <textarea name="keterangan" placeholder="Masukkan keterangan konsultasi..." required class="jwl-input" style="height: 80px; resize: none; font-family: inherit; flex-grow: 1;">{{ $editJadwal->keterangan ?? '' }}</textarea>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; width: 100%; gap: 12px;">
                @if(isset($editJadwal))
                    <a href="{{ route('jadwal.index') }}" style="text-decoration: none; background: #94A3B8; color: white; padding: 12px 24px; border-radius: 10px; font-weight: bold; font-size: 14px; display: flex; align-items: center;">Batal</a>
                @endif
                <button type="submit" class="jwl-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 18px; height: 18px; fill: #FFFFFF;" viewBox="0 0 24 24">
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <div style="background: #FFFFFF; border-radius: 24px; padding: 25px; box-shadow: 0 4px 25px rgba(0, 0, 0, 0.02); border: 1px solid #F1F5F9;">
        <h2 style="font-size: 18px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Daftar Antrean Konsultasi Terjadwal</h2>
        
        <div style="width: 100%; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 1000px; font-size: 14px; color: #334155;">
                <thead>
                    <tr style="background-color: #F84F8F; color: #FFFFFF;">
                        <th style="padding: 16px 20px; font-weight: 600; border-top-left-radius: 14px; border-bottom-left-radius: 14px;">Nama Pasien</th>
                        <th style="padding: 16px 20px; font-weight: 600;">NIK</th>
                        <th style="padding: 16px 20px; font-weight: 600;">Tgl Lahir</th>
                        <th style="padding: 16px 20px; font-weight: 600;">No. HP</th>
                        <th style="padding: 16px 20px; font-weight: 600;">Email</th>
                        <th style="padding: 16px 20px; font-weight: 600;">Tgl Pemeriksaan</th>
                        <th style="padding: 16px 20px; font-weight: 600;">Jam</th>
                        <th style="padding: 16px 20px; font-weight: 600; text-align: center; border-top-right-radius: 14px; border-bottom-right-radius: 14px; width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <p>Jumlah Data Jadwal: {{ $jadwals->count() }}</p>
                <tbody>
                    @forelse($jadwals as $j)
                    <tr style="border-bottom: 1px solid #F1F5F9; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#FFF1F6'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 18px 20px; font-weight: 500; color: #0F172A;">{{ $j->nama ?? $j->nama_pasien }}</td>
                        <td style="padding: 18px 20px;">{{ $j->nik }}</td>
                        <td style="padding: 18px 20px;">{{ $j->tgl_lahir }}</td>
                        <td style="padding: 18px 20px;">{{ $j->no_hp }}</td>
                        <td style="padding: 18px 20px;">{{ $j->user?->user?->email ?? 'Tidak Ditemukan' }}
                        <td style="padding: 18px 20px; font-weight: 500; color: #F84F8F;">{{ date('d-m-Y', strtotime($j->tgl_pemeriksaan)) }}</td>
                        <td style="padding: 18px 20px; font-weight: 600;">{{ $j->jam }} WIB</td>
                        <td style="padding: 14px 20px; text-align: center;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                        <a href="{{ route('jadwal.index', ['edit_id' => $j->id]) }}" 
                        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: #FFCC00; border-radius: 12px; box-shadow: 0 4px 6px rgba(255, 204, 0, 0.2); text-decoration: none; transition: 0.2s;" 
                        title="Edit Jadwal Konsultasi"
                        onmouseover="this.style.backgroundColor='#e6b800'" onmouseout="this.style.backgroundColor='#FFCC00'">
                        <span style="color: #FFFFFF; font-size: 16px;">✎</span>
                    </a>
                    
                    <button type="button" 
        onclick="confirmDelete('{{ $j->id }}', '{{ $j->nama_pasien ?? 'Pasien' }}')" 
        style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: #E2E8F0; border-radius: 12px; box-shadow: 0 4px 6px rgba(226, 232, 240, 0.4); border: none; cursor: pointer; transition: 0.2s;" 
        title="Hapus Jadwal Konsultasi"
        onmouseover="this.style.backgroundColor='#CBD5E1'" 
        onmouseout="this.style.backgroundColor='#E2E8F0'">
    <span style="color: #EF4444; font-size: 20px; font-weight: bold; line-height: 1;">🗑</span>
</button>
            </div>
        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94A3B8; padding: 40px; font-style: italic;">
                            Belum ada jadwal konsultasi yang terdaftar di dalam database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: "Jadwal pemeriksaan milik " + nama + " akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#94A3B8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-[24px]' }
        }).then((result) => {
            if (result.isConfirmed) { 
                let form = document.createElement('form');
                form.action = "/admin/jadwal/" + id;
                form.method = 'POST';
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
</script>
@if(session('success'))
<script>
    Swal.fire({
        text: "{{ session('success') }}",
        showConfirmButton: false, 
        timer: 3500, 
        toast: true, 
        position: 'top', 
        width: 'auto',
        background: '#C6E7CE', 
        color: '#1E293B',      
        customClass: { 
            popup: 'rounded-xl shadow-lg px-6 py-4 font-poppins font-medium' 
        }
    });
</script>
@endif
@endsection