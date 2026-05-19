@extends('layouts.masterAdmin')

@section('title', 'Jadwal Konsultasi - Bumiloo')

@section('content')
<div class="w-full min-h-screen bg-[#F0F2F5] p-4 md:p-8 font-['Poppins',sans-serif] text-[#1E3A5F]">
    
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-[#1E3A5F]">Jadwal Konsultasi</h1>
    </div>

    @if(isset($pasien) && $pasien)
    <div class="mb-6 p-5 bg-white rounded-2xl border-l-[10px] border-[#F875AA] shadow-sm">
        <p class="text-sm md:text-base font-medium text-gray-700">
            Mendaftarkan Jadwal Untuk Pasien: <span class="font-bold text-black">{{ $pasien->name }}</span> 
            <span class="mx-2 text-gray-300">|</span> NIK: <span class="font-bold text-black">{{ $pasien->nik }}</span> 
            <span class="mx-2 text-gray-300">|</span> No. HP: <span class="font-bold text-black">{{ $pasien->no_hp }}</span>
        </p>
    </div>
    @endif

    <div class="bg-[#F8FAFC] rounded-[24px] shadow-sm border border-gray-100 mb-8 overflow-hidden w-full">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                {{ isset($editJadwal) ? 'TAMBAH JADWAL KONSULTASI (EDIT MODE)' : 'TAMBAH JADWAL KONSULTASI' }}
            </span>
        </div>
        
        <form action="{{ isset($editJadwal) ? route('jadwal.update', $editJadwal->id) : route('jadwal.store') }}" method="POST" class="p-6 md:p-8">
            @csrf
            @if(isset($editJadwal)) 
                @method('PUT') 
            @endif

            <input type="hidden" name="nama_pasien" value="{{ $editJadwal->nama_pasien ?? ($pasien->name ?? 'Umum') }}">
            <input type="hidden" name="nik" value="{{ $editJadwal->nik ?? ($pasien->nik ?? '-') }}">
            <input type="hidden" name="no_hp" value="{{ $editJadwal->no_hp ?? ($pasien->no_hp ?? '-') }}">
            <input type="hidden" name="tgl_lahir" value="{{ $editJadwal->tgl_lahir ?? ($pasien->tgl_lahir ?? '-') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Tanggal Pemeriksaan</label>
                    <input type="date" name="tgl_pemeriksaan" value="{{ $editJadwal->tgl_pemeriksaan ?? '' }}" required
                        class="w-full p-3 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-pink-300 focus:border-transparent outline-none font-medium text-[#1E3A5F]">
                </div>
                
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Jam</label>
                    <input type="time" name="jam" value="{{ $editJadwal->jam ?? '' }}" required
                        class="w-full p-3 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-pink-300 focus:border-transparent outline-none font-medium text-[#1E3A5F]">
                </div>

                <div class="md:col-span-2 flex flex-col">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Masukkan detail konsultasi..."
                        class="w-full p-4 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-pink-300 focus:border-transparent outline-none font-medium resize-none text-[#1E3A5F]">{{ $editJadwal->keterangan ?? '' }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                @if(isset($editJadwal))
                    <a href="{{ route('jadwal.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-xl font-bold transition text-sm flex items-center">Batal</a>
                @endif
                <button type="submit" 
                    class="bg-[#F875AA] hover:bg-[#f55a9a] text-white px-6 py-2 rounded-xl font-bold transition-all shadow-sm flex items-center gap-2 transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    <span class="text-sm">{{ isset($editJadwal) ? 'Update' : 'Simpan' }}</span>
                </button>
            </div>
        </form>
    </div>

    <div class="mb-4">
        <h2 class="text-xl font-bold text-[#1E3A5F]">Daftar Jadwal Konsultasi</h2>
    </div>
    
    <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden w-full">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-[#F875AA] text-white">
                    <tr class="text-sm">
                        <th class="p-4 font-bold">Nama Pasien</th>
                        <th class="p-4 font-bold">NIK</th>
                        <th class="p-4 font-bold">No. HP</th>
                        <th class="p-4 font-bold">Tgl Lahir</th>
                        <th class="p-4 font-bold">Tgl Pemeriksaan</th>
                        <th class="p-4 font-bold">Jam</th>
                        <th class="p-4 font-bold">Keterangan</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-xs md:text-sm">
                    @forelse($jadwals as $j)
                    <tr class="border-b border-gray-100 hover:bg-pink-50/20 transition-colors">
                        <td class="p-4 font-semibold text-gray-950">{{ $j->nama_pasien }}</td>
                        <td class="p-4 text-gray-600">{{ $j->nik }}</td>
                        <td class="p-4 text-gray-600">{{ $j->no_hp }}</td>
                        <td class="p-4 text-gray-600">{{ $j->tgl_lahir }}</td>
                        <td class="p-4 font-bold text-gray-950">{{ date('d/m/Y', strtotime($j->tgl_pemeriksaan)) }}</td>
                        <td class="p-4 font-bold text-gray-950">{{ $j->jam }}</td>
                        <td class="p-4 italic text-gray-500 max-w-[180px] truncate" title="{{ $j->keterangan }}">{{ $j->keterangan }}</td>
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('jadwal.index', ['edit_id' => $j->id]) }}" 
                                   class="w-8 h-8 flex items-center justify-center bg-[#D9D9D9] rounded-lg hover:bg-gray-300 transition shadow-sm" 
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#FFD700]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <button type="button" onclick="confirmDelete('{{ $j->id }}', '{{ $j->nama_pasien }}')" 
                                        class="w-8 h-8 flex items-center justify-center bg-[#D9D9D9] rounded-lg hover:bg-gray-300 transition shadow-sm" 
                                        title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#FF0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $j->id }}" action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="hidden">
                                    @csrf 
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400 italic">Belum ada jadwal konsultasi yang terdaftar.</td>
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
            title: 'Hapus Data Pasien?',
            text: "Apakah Anda yakin ingin menghapus jadwal pasien " + nama + "? Tindakan ini tidak dapat dibatalkan",
            icon: 'warning',
            iconColor: '#d33',
            showCancelButton: true,
            confirmButtonColor: '#ff0000',
            cancelButtonColor: '#d1d5db',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[24px]',
                title: 'font-bold text-[#1E3A5F]',
                confirmButton: 'rounded-xl px-6 py-2 font-bold text-sm',
                cancelButton: 'rounded-xl px-6 py-2 font-bold text-sm text-gray-600'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        text: "{{ session('success') }}",
        showConfirmButton: false, 
        timer: 3000, 
        toast: true,
        position: 'top', 
        width: '400px',
        background: '#C6E7CE',
        color: '#000000', 
        showCloseButton: true, 
        customClass: {
            popup: 'rounded-xl shadow-md border border-green-200',
        }
    });
</script>
@endif
@endsection