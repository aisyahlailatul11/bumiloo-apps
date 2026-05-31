@extends('layouts.masterBumil')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    /* Kontainer utama halaman konsultasi */
    .chat-page-container {
        font-family: 'Poppins', sans-serif !important;
        background-color: #fff3fb !important; 
        padding: 20px;
        min-height: calc(100vh - 40px); 
        display: flex;
        align-items: column;
    }

    .chat-row-layout {
        width: 100%;
        margin: 0;
        display: flex;
        flex-grow: 1;
    }

    .sidebar .nav-item a.nav-link[href*="konsultasi"],
    .sidebar .nav-link.active,
    .main-sidebar .nav-link[href*="konsultasi"] {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #FFFFFF !important;
        font-weight: 600 !important;
        border-radius: 12px !important;
    }
    .sidebar .nav-item a.nav-link[href*="konsultasi"] i,
    .sidebar .nav-link.active i {
        color: #FFFFFF !important;
    }

    /* STYLING CHAT ROOM (SISI KANAN) */
    .chat-room-card {
        background: #FFFFFF !important;
        border-radius: 30px !important;
        border: none !important;
        height: 100% !important;
        min-height: calc(100vh - 100px) !important;
        overflow: hidden;
        display: flex !important;
        flex-direction: column; 
    }

    .chat-header-custom {
        background: #FFFFFF !important;
        border-bottom: 1px solid #E2E8F0 !important;
        padding: 15px 30px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-shrink: 0 !important; 
    }

    .btn-end-chat {
        border: 2px solid #F84F8F !important; 
        color: #F84F8F !important;
        font-weight: 600 !important;
        border-radius: 50px !important;
        padding: 6px 22px !important;
        background: transparent !important;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-end-chat:hover {
        background: #F84F8F !important;
        color: #FFFFFF !important;
    }

    .chat-body-custom {
        background: linear-gradient(150deg, #ffdfe5 0%, #ffe0e6 45%, #ffa9e4 45.2%, #ffa9e4 100%) !important;
        padding: 25px 30px !important;
        overflow-y: auto !important;
        flex-grow: 1 !important; 
        display: flex !important;
        flex-direction: column !important;
    }
    
    .chat-row-bumil {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }
    .bubble-bumil {
        background: #F5B6AE !important; 
        color: #000000 !important;
        border-radius: 25px 25px 0px 25px !important; 
        padding: 18px 26px !important;
        max-width: 70%;
        position: relative;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.15);
    }
    .bubble-bumil::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: -10px;
        width: 0;
        height: 0;
        border-bottom: 15px solid #F5B6AE;
        border-right: 15px solid transparent;
    }

    .chat-row-bidan {
        display: flex;
        justify-content: flex-start;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 25px;
    }
    .bubble-bidan {
        background: #FFFFFF !important;
        color: #000000 !important;
        border-radius: 25px 25px 25px 0px !important; 
        padding: 18px 26px !important;
        max-width: 70%;
        position: relative;
        box-shadow: -5px 5px 15px rgba(0, 0, 0, 0.1);
    }
    .bubble-bidan::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: -10px;
        width: 0;
        height: 0;
        border-bottom: 15px solid #FFFFFF;
        border-left: 15px solid transparent;
    }

    .chat-time {
        font-size: 11px;
        color: #666666;
        display: block;
        text-align: right;
        margin-top: 8px;
        font-weight: 400;
    }

    .avatar-chat-bidan {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1.5px solid #7E7E7E;
        overflow: hidden; 
    }

    .avatar-chat-bidan img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* FOOTER FORM INPUT CHAT */
    .chat-footer-custom {
        background: #FFFFFF !important;
        padding: 15px 25px 20px 25px !important;
        border-top: 1px solid #E2E8F0 !important;
        flex-shrink: 0 !important; 
    }

    .input-wrapper-custom {
        background: #F1F5F9 !important; 
        border-radius: 50px !important;
        padding: 6px 10px 6px 24px !important;
        display: flex;
        align-items: center;
        border: 1px solid #E2E8F0;
    }

    .input-chat-field {
        border: none !important;
        background: transparent !important;
        outline: none !important;
        box-shadow: none !important;
        font-size: 14px;
        color: #000000;
        flex-grow: 1;
        padding: 8px 0 !important;
    }

    .btn-clip-attachment {
        background: transparent !important;
        border: none !important;
        color: #94A3B8 !important;
        font-size: 20px !important;
        margin-right: 15px !important;
        cursor: pointer;
    }

    .btn-send-round {
        background: #F84F8F !important; 
        color: #FFFFFF !important;
        width: 42px;
        height: 42px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none !important;
        transition: transform 0.1s ease;
    }
    .btn-send-round:hover {
        transform: scale(1.05);
    }

    /* MODAL POPUP & SPINNER STYLING */
    .custom-modal-content {
        border-radius: 40px !important; 
        border: none !important;
        padding: 45px 30px !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .modal-title-custom {
        font-weight: 700;
        font-size: 24px;
        color: #000000;
        line-height: 1.4;
    }
    .modal-desc-custom {
        font-size: 14px;
        color: #4A4A4A;
        font-weight: 500;
        line-height: 1.5;
    }
    
    /* MODAL SPINNER TICK SPINNER */
    .pink-spinner {
        width: 70px;
        height: 70px;
        margin: 35px auto;
        position: relative;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='15' r='7' fill='%23F84F8F' opacity='1'/%3E%3Ccircle cx='75' cy='25' r='7' fill='%23F84F8F' opacity='0.85'/%3E%3Ccircle cx='85' cy='50' r='7' fill='%23F84F8F' opacity='0.7'/%3E%3Ccircle cx='75' cy='75' r='7' fill='%23F84F8F' opacity='0.55'/%3E%3Ccircle cx='50' cy='85' r='7' fill='%23F84F8F' opacity='0.4'/%3E%3Ccircle cx='25' cy='75' r='7' fill='%23F84F8F' opacity='0.3'/%3E%3Ccircle cx='15' cy='50' r='7' fill='%23F84F8F' opacity='0.2'/%3E%3Ccircle cx='25' cy='25' r='7' fill='%23F84F8F' opacity='0.1'/%3E%3C/svg%3E") no-repeat center;
        background-size: contain;
        animation: spin-dots 1s steps(8) infinite;
    }
    @keyframes spin-dots {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="chat-page-container container-fluid d-flex flex-column">
    
    {{-- Notifikasi Sukses / Eror --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-3" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-3" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row w-100 m-0 flex-nowrap flex-grow-1">
        
        <div class="flex-grow-1">
            <div class="row chat-row-layout g-4">

                {{-- SISI KANAN: CHAT ROOM UTAMA --}}
                <div class="col-md-20">
                    <div class="card chat-room-card">
                        <div class="chat-header-custom">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle border overflow-hidden d-flex align-items-center justify-content-center bg-light me-3" style="width: 50px; height: 50px; border: 2.5px solid #7E7E7E !important;">
                                    <img src="{{ asset('images/iconchatbidan.png') }}" alt="Icon Bidan" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 20px;">Bidan Siti Fatimah, S.Tr.Keb</h6>
                                    <small class="text-success fw-bold" style="font-size: 15px;">Online</small>
                                </div>
                            </div>
                            <a href="{{ route('bumil.dashboard') }}" class="btn btn-end-chat">
                                <i class="fas fa-sign-out-alt"></i> Akhiri chat
                            </a>
                        </div>

                        <div class="chat-body-custom">
                            <div class="text-center mb-8">
                                <span class="badge bg-white text-dark border px-4 py-2 rounded-4" style="font-size: 11px; box-shadow: 0 1px 3px hsla(0, 0%, 0%, 0.05);">Hari ini</span>
                            </div>

                            @forelse($pesans as $chat)
                                @if($chat->sender == 'bumil')
                                    <div class="chat-row-bumil">
                                        <div class="bubble-bumil">
                                            <p class="mb-0" style="font-size: 13.5px; line-height: 1.6;">{{ $chat->pesan }}</p>
                                            <span class="chat-time">{{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="chat-row-bidan">
                                        <div class="avatar-chat-bidan">
                                            <img src="{{ asset('images/iconchatbidan.png') }}" alt="Bidan">
                                        </div>
                                        <div class="bubble-bidan">
                                            @if(($chat->tipe_pesan ?? 'text') == 'request_offline')
                                                <p class="mb-3 text-dark" style="font-size: 13.5px;">
                                                    halo Bunda, jika bersedia untuk melakukan konsultasi offline di PMB silakan klik link pendaftaran berikut ya HPL bunda sudah mendekati 2 hari ini saya khawatir nyeri yang bunda rasakan tanda persalinan
                                                </p>
                                                
                                                {{-- 🔥 LOGIKA MENEMBAK STATUS KONSULTASI DI TB_PENDAFTARAN 🔥 --}}
                                                @php
                                                    $dataPendaftaran = \DB::table('tb_pendaftaran')
                                                        ->where('user_id', auth()->id())
                                                        ->latest()
                                                        ->first();
                                                @endphp

                                                @if($dataPendaftaran && $dataPendaftaran->status_konsultasi == 'menunggu')
                                                    {{-- Status 'menunggu' -> Tombol dikunci (Kuning) --}}
                                                    <button type="button" class="btn text-white w-100 py-2 fw-bold text-center" disabled
                                                            style="background:#ffc107; border-radius:12px; font-size: 12px; cursor: not-allowed;">
                                                        <i class="fas fa-spinner fa-spin me-1"></i> ⏳ Menunggu Konfirmasi Bidan
                                                    </button>
                                                @elseif($dataPendaftaran && $dataPendaftaran->status_konsultasi == 'terjadwal')
                                                    {{-- Status 'terjadwal' -> Muncul badge sukses (Hijau) --}}
                                                    <div class="alert alert-success text-center py-2 px-3 fw-bold m-0" 
                                                         style="border-radius:12px; font-size: 12px; border: none; background-color: #d1fae5; color: #065f46;">
                                                        <i class="fas fa-check-circle me-1"></i> Sudah Terjadwal
                                                    </div>
                                                @else
                                                    {{-- Belum ada status / Data Kosong -> Muncul tombol buat daftar --}}
                                                    <form action="{{ route('konsultasi.ajukan') }}" method="POST" id="formAjukanJadwal">
                                                        @csrf
                                                        <button type="submit" class="btn text-white w-100 py-2 fw-bold text-center"
                                                                style="background:#F84F8F; border-radius:12px; font-size: 12px;">
                                                            <i class="fas fa-calendar-alt me-1"></i> Ajukan Jadwal Offline
                                                        </button>
                                                    </form>
                                                @endif

                                            @else
                                                <p class="mb-0" style="font-size: 13.5px; line-height: 1.6; white-space: pre-line;">{{ $chat->pesan }}</p>
                                            @endif
                                            <span class="chat-time">{{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center w-100 mt-3">
                                    <div class="text-muted" style="font-size: 13.5px; background: #FFFFFF; padding: 12px 35px; border-radius: 50px; display: inline-block; color: #000000 !important; font-weight: 500; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                        Belum ada pesan konsultasi. Mulai obrolan dengan Bidan.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="chat-footer-custom">
                            <form action="{{ route('bumil.konsultasi.kirim') }}" method="POST" class="m-0">
                                @csrf
                                <div class="input-wrapper-custom">
                                    <button type="button" class="btn-clip-attachment">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                    <input type="text" name="pesan" class="input-chat-field" placeholder="Ketik pesan....." required autocomplete="off">
                                    <button type="submit" class="btn-send-round">
                                        <i class="fas fa-paper-plane" style="font-size: 13px; margin-left: -2px;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- MODAL POPUP LOADING SPIN PINK --}}
<div class="modal fade" id="prosesJadwalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal-content">
            <div class="modal-body text-center">
                <h3 class="modal-title-custom mb-3">Pendaftaran Konsultasi Offline<br>Bunda Sedang Diproses</h3>
                
                <div class="pink-spinner"></div>
                
                <p class="modal-desc-custom m-0 mt-3">
                    Mohon bersabar ya Bunda, jadwal akan muncul setelah dikonfirmasi oleh Bidan.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pemicu modal --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('formAjukanJadwal');
        if(form) {
            form.addEventListener('submit', function(e) {
                var modalElement = document.getElementById('prosesJadwalModal');
                var myModal = new bootstrap.Modal(modalElement);
                myModal.show();
            });
        }
    });
</script>
@endsection