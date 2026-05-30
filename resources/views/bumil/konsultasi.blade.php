@extends('layouts.masterBumil')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    /* FIX: Mengatur avatar chat agar putih, bulat penuh, dan tidak terpotong */
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
        border-radius: 30px !important;
        border: none !important;
        padding: 40px 25px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .modal-title-custom {
        font-weight: 700;
        font-size: 22px;
        color: #000000;
        line-height: 1.4;
    }
    .modal-desc-custom {
        font-size: 13.5px;
        color: #4A4A4A;
        font-weight: 500;
    }
    .pink-spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #F84F8F;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 30px auto;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="chat-page-container container-fluid d-flex flex-column">
    
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
                                                <p class="mb-3 text-dark fw-bold" style="font-size: 13.5px;">
                                                    <i class="fas fa-info-circle me-1" style="color: #F84F8F;"></i> {{ $chat->pesan }}
                                                </p>
                                                <button type="button" class="btn text-white w-100 py-2 fw-bold text-center"
                                                        style="background:#F84F8F; border-radius:12px; font-size: 12px;"
                                                        data-bs-toggle="modal" data-bs-target="#prosesJadwalModal">
                                                    <i class="fas fa-calendar-alt me-1"></i> Ajukan Jadwal Offline
                                                </button>
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

{{-- MODAL POPUP --}}
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
@endsection