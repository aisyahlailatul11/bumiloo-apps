@extends('layouts.masterBumil')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    /* Kontainer utama halaman konsultasi */
    .chat-page-container {
        font-family: 'Poppins', sans-serif !important;
        background-color: #000000 !important; 
        padding: 25px;
        min-height: calc(100vh - 60px); 
        display: flex;
        align-items: stretch;
    }

    .chat-row-layout {
        width: 100%;
        margin: 0;
        display: flex;
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

    /* STYLING PROFILE BIDAN (SISI KIRI) */
    .bidan-profile-card {
        background: #FFFFFF !important;
        border: none !important;
        border-radius: 30px !important;
        padding: 35px 24px !important;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
    }

    .title-top {
        font-size: 15px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 30px;
        text-align: left;
    }

    /* FIX: Set border dan overflow agar gambar bulat sempurna */
    .img-profile-wrapper {
        width: 150px;
        height: 150px;
        border: 2.5px solid #7E7E7E; 
        border-radius: 50%;
        margin: 0 auto 15px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FFFFFF;
        overflow: hidden; 
    }

    .img-profile-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nama-bidan {
        font-size: 16px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 12px;
    }

    .badge-online {
        background-color: #DCFCE7 !important; 
        color: #16A34A !important; 
        font-weight: 600 !important;
        padding: 6px 24px !important;
        border-radius: 50px !important;
        font-size: 14px !important;
        border: none !important;
        display: inline-block;
        margin-bottom: 35px;
    }

    .info-box-jadwal {
        background: #FDF0F2 !important; 
        border-radius: 24px !important;
        padding: 20px 24px !important;
        text-align: left;
        margin-bottom: 20px;
    }

    .info-box-tips {
        background: #F9C9C3 !important; 
        border-radius: 24px !important;
        padding: 20px 24px !important;
        text-align: left;
    }

    .box-title {
        font-size: 14px;
        font-weight: 700;
        color: #000000;
        margin: 0;
    }

    .box-desc {
        font-size: 13px;
        color: #000000;
        font-weight: 400;
        line-height: 1.6;
        margin: 0;
    }

    /* STYLING CHAT ROOM (SISI KANAN) */
    .chat-room-card {
        background: #FFFFFF !important;
        border-radius: 30px !important;
        border: none !important;
        height: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column; 
    }

    .chat-header-custom {
        background: #FFFFFF !important;
        border-bottom: 1px solid #E2E8F0 !important;
        padding: 15px 30px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0; 
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
        background: linear-gradient(135deg, #D6BEC2 0%, #CBB4B9 45%, #221B21 45.2%, #2C252B 100%) !important;
        padding: 25px 30px !important;
        overflow-y: auto;
        flex-grow: 1; 
        position: relative;
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
        flex-shrink: 0; 
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

<div class="chat-page-container container-fluid">
    <div class="row chat-row-layout g-4">

        {{-- SISI KIRI: PROFILE BIDAN --}}
        <div class="col-md-4">
            <div class="card bidan-profile-card">
                <div class="title-top">Bidan Praktik</div>
                <div class="img-profile-wrapper">
                    <img src="{{ asset('images/iconchatbidan.png') }}" alt="Icon Bidan">
                </div>
                <div class="nama-bidan text-center">Bidan Siti Fatimah, S.Tr.Keb</div>
                <div class="text-center">
                    <span class="badge badge-online">Online</span>
                </div>
                <div class="info-box-jadwal">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="far fa-calendar-alt text-dark" style="font-size: 18px;"></i>
                        <h6 class="box-title">Jadwal Praktik</h6>
                    </div>
                    <div style="padding-left: 32px;">
                        <p class="box-desc">Praktik setiap hari<br>08.00-16.00</p>
                    </div>
                </div>
                <div class="info-box-tips">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="far fa-lightbulb text-dark" style="font-size: 18px;"></i>
                        <h6 class="box-title">Tips</h6>
                    </div>
                    <div style="padding-left: 32px;">
                        <p class="box-desc" style="text-align: justify;">Diskusikan keluhan Anda dengan bidan secara terbuka agar mendapatkan saran yang tepat.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: CHAT ROOM UTAMA --}}
        <div class="col-md-8">
            <div class="card chat-room-card">
                <div class="chat-header-custom">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle border overflow-hidden d-flex align-items-center justify-content-center bg-light me-3" style="width: 50px; height: 50px; border: 2.5px solid #7E7E7E !important;">
                            <img src="{{ asset('images/iconchatbidan.png') }}" alt="Icon Bidan" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 14px;">Bidan Siti Fatimah, S.Tr.Keb</h6>
                            <small class="text-success fw-bold" style="font-size: 11px;">Online</small>
                        </div>
                    </div>
                    <a href="{{ route('bumil.dashboard') }}" class="btn btn-end-chat">
                        <i class="fas fa-sign-out-alt"></i> Akhiri chat
                    </a>
                </div>

                <div class="chat-body-custom">
                    <div class="text-center mb-4">
                        <span class="badge bg-white text-dark border px-4 py-2 rounded-4" style="font-size: 11px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">Hari ini</span>
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

{{-- MODAL POPUP --}}
<div class="modal fade" id="prosesJadwalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal-content">
            <div class="modal-body text-center">
                <h3 class="modal-title-custom mb-3">Pendaftaran Konsultasi Offline<br>Bunda Sedang Diproses</h3>
                
                <div class="pink-spinner"></div>
                
                <p class="modal-desc-custom m-0 mt-3">
                    Mohon bersabar ya Bunda, jadwal akan muncul setelah dikonfirmasi oleh Bidan.
                </