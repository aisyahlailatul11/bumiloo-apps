@extends('layouts.masterAdmin')

@section('title', 'Data Pasien - Bumiloo')

@section('content')
<main class="p-10" style="font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 28px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Data Pasien</h1>
    <p class="text-sm font-bold text-gray-500 mb-6">Total Pasien : {{ $totalPasien }}</p>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
    <a href="{{ route('master.createDataPasien') }}" 
       style="background-color: #F84F8F; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 10px rgba(248, 79, 143, 0.3);">
        + Tambah Pasien
    </a>
</div>

   <div style="display: flex; justify-content: space-between; align-items: center; background: #FFF; padding: 20px; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    
    <div style="display: flex; gap: 10px;">
    <a href="?status=semua" 
       style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
              background-color: {{ request('status', 'semua') == 'semua' ? '#6B7280' : '#E2E8F0' }}; 
              color: {{ request('status', 'semua') == 'semua' ? '#FFF' : '#4A5568' }};">
        Semua
    </a>

    <a href="?status=menunggu" 
       style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
              background-color: {{ request('status') == 'menunggu' ? '#F59E0B' : '#E2E8F0' }}; 
              color: {{ request('status') == 'menunggu' ? '#FFF' : '#4A5568' }};">
        Menunggu
    </a>

    <a href="?status=terjadwal" 
       style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
              background-color: {{ request('status') == 'terjadwal' ? '#10B981' : '#E2E8F0' }}; 
              color: {{ request('status') == 'terjadwal' ? '#FFF' : '#4A5568' }};">
        Terjadwal
    </a>
</div>

<form action="" method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Cari nama pasien..." style="padding: 10px 15px; border: 1px solid #E2E8F0; border-radius: 8px; width: 250px;">
        <button type="submit" style="padding: 10px 20px; background: #4299E1; color: white; border: none; border-radius: 8px; cursor: pointer;">Cari</button>
    </form>
</div>
    
    <div style="width: 100%; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 1000px; font-size: 14px; color: #334155;">
            
            <thead>
                <tr style="background-color: #F875AA; color: #FFFFFF;">
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center; border-top-left-radius: 24px;">No</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Nama Pasien</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">NIK</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">No. HP</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Tempat Lahir</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Tgl Lahir</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Umur</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Alamat</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Agama</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Pendidikan</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Gol</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Pekerjaan</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Nama Suami</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">HPHT</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Status Konsultasi</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center; border-top-right-radius: 24px; width: 140px;">Aksi</th>
                </tr>
            </thead>
            
            <tbody style="color: #4A5568;">
    @forelse($pasiens as $index => $p)
        @php
            $isMenunggu = (isset($p->status_konsultasi) && $p->status_konsultasi == 'menunggu');
            $rowBg = $isMenunggu ? '#FFF7ED' : ($index % 2 == 0 ? '#FFFFFF' : '#FFF5F7');
        @endphp
                
                <tr style="background-color: {{ $rowBg }}; border-bottom: 1px solid #EDF2F7; transition: 0.2s;" onmouseover="this.style.backgroundColor='#FDE2E4'" onmouseout="this.style.backgroundColor='{{ $rowBg }}'">
                    <td style="padding: 16px; text-align: center; font-weight: 500; border-r: 1px solid #EDF2F7;">{{ $index + 1 }}</td>
                    <td style="padding: 16px; font-weight: 700; color: #000000; text-transform: uppercase;">{{ $p->nama ?? '-' }}</td>
                    <td style="padding: 16px; letter-spacing: 0.05em;">{{ $p->nik ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->no_hp ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->tempat_lahir ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->tgl_lahir ? date('d-m-Y', strtotime($p->tgl_lahir)) : '-' }}</td>
                    <td style="padding: 16px; text-align: center; font-weight: 700;">{{ $p->umur ?? '-' }} Thn</td>
                    <td style="padding: 16px; text-align: center; max-width: 200px; overflow: hidden;">{{ $p->alamat ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->agama ?? '-' }}</td>
                    <td style="padding: 16px; text-align: center;">{{ $p->pendidikan ?? '-' }}</td>
                    <td style="padding: 16px; text-align: center; font-weight: 700; color: #E91E63;">{{ $p->gol_darah ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->pekerjaan ?? '-' }}</td>
                    <td style="padding: 16px; font-weight: 500;">{{ $p->nama_suami ?? '-' }}</td>
                    <td style="padding: 16px; font-weight: 700; color: #B83280;">{{ $p->hpht ? date('d-m-Y', strtotime($p->hpht)) : '-' }}</td>
                    <td style="padding: 16px; text-align: center; vertical-align: middle;"><span class="badge badge-{{ $p->status_color }}">{{ $p->status_konsultasi }}</span></td>
                    
                    <td style="padding: 16px; text-align: center;">
                        <div style="display: flex; justify-content: center; items-center: center; gap: 8px;">
                            
                            <a href="{{ route('jadwal.index', ['pendaftaran_id' => $p->id]) }}" 
                               style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: #4CD964; border-radius: 12px; box-shadow: 0 4px 6px rgba(76, 217, 100, 0.2); text-decoration: none; transition: 0.2s;" 
                               title="Buat Jadwal Pemeriksaan Pasien"
                               onmouseover="this.style.backgroundColor='#3ec456'" onmouseout="this.style.backgroundColor='#4CD964'">
                                <span style="color: #FFFFFF; font-weight: 700; font-size: 18px;">+</span>
                            </a>   
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="15" style="padding: 40px; text-align: center; color: #A0AEC0; font-style: italic; font-weight: 500;">
                        Belum ada data rekam medis pasien yang tercatat di database Bumiloo.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection