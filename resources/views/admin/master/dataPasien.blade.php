@extends('layouts.masterAdmin')

@section('title', 'Data Pasien - Bumiloo')

@section('content')
<main class="p-10" style="font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 28px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Data Pasien</h1>
    <p class="text-sm font-bold text-gray-500 mb-6">Total Pasien : {{ $totalPasien }}</p>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
        <a href="{{ route('master.createDataPasien') }}" 
           style="background-color: #F84F8F; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600;">
           + Tambah Pasien
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; background: #FFF; padding: 20px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <div style="display: flex; gap: 10px;">
            @foreach(['semua' => 'Semua', 'menunggu' => 'Menunggu', 'terjadwal' => 'Terjadwal', 'Datang Langsung' => 'Offline'] as $key => $label)
            <a href="?status={{ $key }}" 
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; 
               background-color: {{ request('status', 'semua') == $key ? '#F84F8F' : '#E2E8F0' }}; 
               color: {{ request('status', 'semua') == $key ? '#FFF' : '#4A5568' }};">
                {{ $label }}
            </a>
            @endforeach
        </div>
        <form action="{{ route('admin.master.pasien') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama..." style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            <button type="submit" style="padding: 10px 20px; background: #3B82F6; color: white; border: none; border-radius: 8px;">Cari</button>
        </form>
    </div>

    <div style="width: 100%; overflow-x: auto; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background: white;">
        <table style="width: 100%; min-width: 1300px; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #F875AA; color: #FFFFFF;">
                    <th style="padding: 16px; border-top-left-radius: 16px; text-align: center">No</th>
                    <th style="padding: 16px; text-align: center">Nama</th>
                    <th style="padding: 16px; text-align: center">NIK</th>
                    <th style="padding: 16px; text-align: center">No. HP</th>
                    <th style="padding: 16px; text-align: center">Tempat Lahir</th>
                    <th style="padding: 16px; text-align: center">Tgl Lahir</th>
                    <th style="padding: 16px; text-align: center">Umur</th>
                    <th style="padding: 16px; text-align: center">Alamat</th>
                    <th style="padding: 16px; text-align: center">Agama</th>
                    <th style="padding: 16px; text-align: center">Pendidikan</th>
                    <th style="padding: 16px; text-align: center">Gol. Darah</th>
                    <th style="padding: 16px; text-align: center">Pekerjaan</th>
                    <th style="padding: 16px; text-align: center">Nama Suami</th>
                    <th style="padding: 16px; text-align: center">HPHT</th>
                    <th style="padding: 16px; text-align: center">Status Konsultasi</th>
                    <th style="padding: 16px; text-align: center; border-top-right-radius: 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $index => $p)
                <tr style="border-bottom: 1px solid #eee; text-align: center;">
                    <td style="padding: 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px; font-weight: bold;">{{ $p->nama }}</td>
                    <td style="padding: 12px;">{{ $p->nik }}</td>
                    <td style="padding: 12px;">{{ $p->no_hp }}</td>
                    <td style="padding: 12px;">{{ $p->tempat_lahir }}</td>
                    <td style="padding: 12px;">{{ $p->tgl_lahir }}</td>
                    <td style="padding: 12px;">{{ $p->umur }}</td>
                    <td style="padding: 12px;">{{ $p->alamat }}</td>
                    <td style="padding: 12px;">{{ $p->agama }}</td>
                    <td style="padding: 12px;">{{ $p->pendidikan }}</td>
                    <td style="padding: 12px;">{{ $p->gol_darah }}</td>
                    <td style="padding: 12px;">{{ $p->pekerjaan }}</td>
                    <td style="padding: 12px;">{{ $p->nama_suami }}</td>
                    <td style="padding: 12px;">{{ $p->hpht }}</td>
                    <td style="padding: 12px;">{{ $p->status_konsultasi }}</td>
                    <td style="padding: 12px; text-align: center; vertical-align: middle;">
    @php
        $status = strtolower(trim($p->status_konsultasi ?? ''));
    @endphp

    @if($status == 'terjadwal')
        <a href="{{ route('jadwal.index', ['pendaftaran_id' => $p->id]) }}" 
           style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; background-color: #FF9500; border-radius: 12px; box-shadow: 0 4px 6px rgba(255, 149, 0, 0.2); text-decoration: none; color: white;" 
           title="Edit Jadwal">
           <i class="fa fa-edit"></i>
        </a>

    @elseif($status == 'menunggu' || empty($status))
        <a href="{{ route('jadwal.index', ['pendaftaran_id' => $p->id]) }}" 
           style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; background-color: #4CD964; border-radius: 12px; box-shadow: 0 4px 6px rgba(76, 217, 100, 0.2); text-decoration: none; color: white; font-weight: bold; font-size: 20px;" 
           title="Buat Jadwal">
           +
        </a>

    @else
        <span style="color: #6B7280; background: #F3F4F6; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 600;">
            OFFLINE
        </span>
    @endif
</td>
                </tr>
                @empty
                <tr><td colspan="16" style="padding: 20px; text-align: center;">Data tidak ada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection