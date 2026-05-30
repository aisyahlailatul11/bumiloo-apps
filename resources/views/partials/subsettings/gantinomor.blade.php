@extends('layouts.settingsMaster') 

@section('setting_content') 
<div class="container-lg mt-4">

    {{-- Alert dan error --}}

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="fw-bold text-dark mb-0">Ubah Nomor HP</h5>
        </div>
        <div class="card-body">
            <form id="formNoHp" action="{{ route('update.nohp') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">No HP Lama</label>
                    <input type="text" name="no_hp_lama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">No HP Baru</label>
                    <input type="text" name="no_hp_baru" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Konfirmasi Nomor HP Baru</label>
                    <input type="text" name="no_hp_konfirmasi" class="form-control" required>
                </div>
                <small class="text-muted">*Pastikan nomor HP yang dimasukkan aktif dan dapat dihubungi.</small>

                <div class="d-flex justify-content-end mt-4">
                    {{-- Tombol Reset --}}
                    <button type="reset" class="btn btn-warning me-2">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn btn-pink" style="background-color:#f875aa; color:white;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 