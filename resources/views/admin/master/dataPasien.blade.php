@extends('layouts.masterAdmin')

@section('title', 'Data Pasien - Bumiloo')

@section('content')
<main class="p-10">
    <h2 class="text-3xl font-bold text-black mb-1">Data Pasien</h2>
    <p class="text-sm font-bold text-gray-500 mb-6">Total Pasien Terdaftar : {{ $totalPasien }}</p>
    
    <h3 class="text-lg font-bold mb-4 border-b-2 border-pink-500 w-fit pb-1">Tabel Data Pasien (Pendaftaran)</h3>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1200px]">
            <thead class="bg-[#F875AA] text-white">
                <tr class="text-sm">
                    <th class="p-5 font-bold">ID</th>
                    <th class="p-5 font-bold">NIK</th>
                    <th class="p-5 font-bold">Nama</th>
                    <th class="p-5 font-bold">Tempat Lahir</th>
                    <th class="p-5 font-bold">Tgl Lahir</th>
                    <th class="p-5 font-bold">Alamat</th>
                    <th class="p-5 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($pasiens as $index => $p)
                <tr class="border-b border-gray-50 hover:bg-pink-50/40 transition-colors">
                    <td class="p-5">{{ $index + 1 }}</td>
                    <td class="p-5">{{ $p->nik ?? '-' }}</td>
                    <td class="p-5 font-bold text-black uppercase">{{ $p->nama ?? '-' }}</td>
                    <td class="p-5">{{ $p->tempat_lahir ?? '-' }}</td>
                    <td class="p-5">{{ $p->tgl_lahir ?? '-' }}</td>
                    <td class="p-5 italic">{{ $p->alamat ?? '-' }}</td>
                    <td class="p-5">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('jadwal.index', ['pasien_id' => $p->id]) }}" 
                               class="w-10 h-10 flex items-center justify-center bg-[#4CD964] rounded-xl hover:bg-[#3ec456] transition shadow-md" title="Tambah Jadwal">
                                <span class="text-white font-bold text-xl">+</span>
                            </a>
                            <a href="{{ route('master.pasien.edit', $p->id) }}" 
                               class="w-10 h-10 flex items-center justify-center bg-[#FFCC00] rounded-xl hover:bg-[#e6b800] transition shadow-md" title="Edit Data">
                                <span class="text-white text-xl">✎</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-sm font-medium text-gray-400 italic">
                        Belum ada data pasien di sistem.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection