@extends('layouts.masterAdmin')

@section('title', 'Data Pasien - Bumiloo')

@section('content')
<main class="p-10" style="font-family: 'Poppins', sans-serif;">
    <h2 class="text-3xl font-bold text-black mb-1">Data Pasien</h2>
    <p class="text-sm font-bold text-gray-500 mb-6">Total Pasien : {{ $totalPasien }}</p>
    
    <div style="width: 100%; overflow-x: auto; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); background-color: #FFFFFF;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 1600px; font-size: 15px;">
            
            <thead>
                <tr style="background-color: #F875AA; color: #FFFFFF;">
                    <th style="padding: 18px 16px; font-weight: 700; border-top-left-radius: 24px;">No</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Nama Pasien</th>
                    <th style="padding: 18px 16px; font-weight: 700;">NIK</th>
                    <th style="padding: 18px 16px; font-weight: 700;">No. HP</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Tempat Lahir</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Tgl Lahir</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Umur</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Alamat</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Agama</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Pendidikan</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center;">Gol</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Pekerjaan</th>
                    <th style="padding: 18px 16px; font-weight: 700;">Nama Suami</th>
                    <th style="padding: 18px 16px; font-weight: 700;">HPHT</th>
                    <th style="padding: 18px 16px; font-weight: 700; text-align: center; border-top-right-radius: 24px; width: 140px;">Aksi</th>
                </tr>
            </thead>
            
            <tbody style="color: #4A5568;">
                @forelse($pasiens as $index => $p)
                    @php
                        // Logika saringan untuk highlight baris bermasalah / butuh jadwal
                        $isButuhJadwal = (isset($p->status_konsultasi) && $p->status_konsultasi == 'butuh_jadwal');
                        $rowBg = $isButuhJadwal ? '#FFEFEB' : ($index % 2 == 0 ? '#FFFFFF' : '#FFF5F7');
                    @endphp
                
                <tr style="background-color: {{ $rowBg }}; border-bottom: 1px solid #EDF2F7; transition: 0.2s;" onmouseover="this.style.backgroundColor='#FDE2E4'" onmouseout="this.style.backgroundColor='{{ $rowBg }}'">
                    <td style="padding: 16px; text-align: center; font-weight: 500; border-r: 1px solid #EDF2F7;">{{ $index + 1 }}</td>
                    <td style="padding: 16px; font-weight: 700; color: #000000; text-transform: uppercase;">{{ $p->nama ?? '-' }}</td>
                    <td style="padding: 16px; letter-spacing: 0.05em;">{{ $p->nik ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->no_hp ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->tempat_lahir ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->tgl_lahir ? date('d-m-Y', strtotime($p->tgl_lahir)) : '-' }}</td>
                    <td style="padding: 16px; text-align: center; font-weight: 700;">{{ $p->umur ?? '-' }} Thn</td>
                    <td style="padding: 16px; font-style: italic; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p->alamat ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->agama ?? '-' }}</td>
                    <td style="padding: 16px; text-align: center;">{{ $p->pendidikan ?? '-' }}</td>
                    <td style="padding: 16px; text-align: center; font-weight: 700; color: #E91E63;">{{ $p->gol_darah ?? '-' }}</td>
                    <td style="padding: 16px;">{{ $p->pekerjaan ?? '-' }}</td>
                    <td style="padding: 16px; font-weight: 500;">{{ $p->nama_suami ?? '-' }}</td>
                    <td style="padding: 16px; font-weight: 700; color: #B83280;">{{ $p->hpht ? date('d-m-Y', strtotime($p->hpht)) : '-' }}</td>
                    
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