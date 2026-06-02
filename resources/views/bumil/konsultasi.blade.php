@extends('layouts.masterBumil')

@section('content')
<style>
    /* Kontainer utama chat */
    .chat-container-main {
        background: #fff3fb;
        padding: 20px;
        min-height: 80vh;
        display: flex;
        flex-direction: column;
    }

    /* Kartu Chat Room */
    .chat-card {
        background: #ffffff;
        border-radius: 30px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        height: 75vh;
        overflow: hidden;
    }

    /* Area Pesan */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #fff0f5; /* Warna wallpaper */
    }

    /* Bubble Chat */
    .row-bidan { display: flex; justify-content: flex-start; margin-bottom: 20px; }
    .row-bumil { display: flex; justify-content: flex-end; margin-bottom: 20px; }
    
    .bubble {
        padding: 15px 20px;
        border-radius: 20px;
        max-width: 60%;
        font-size: 14px;
        position: relative;
    }
    .bubble-bidan { background: #fff; border-bottom-left-radius: 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .bubble-bumil { background: #F84F8F; color: white; border-bottom-right-radius: 0; }

    /* Footer Input */
    .chat-footer {
        padding: 15px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }
</style>

<div class="chat-container-main">
    <div class="card chat-card">
        <div class="chat-header-custom p-3 border-bottom d-flex align-items-center" 
     style="cursor: pointer; transition: background 0.3s;" 
     data-bs-toggle="modal" 
     data-bs-target="#modalDataBidan"
     onmouseover="this.style.background='#fcfcfc'" 
     onmouseout="this.style.background='transparent'">
    
    <div class="position-relative">
        <img src="{{ asset('images/iconchatbidan.png') }}" width="50" height="50" class="rounded-circle shadow-sm" style="object-fit: cover; border: 2px solid #F84F8F;">
        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
    </div>
    
    <div class="ms-3">
        <h5 class="mb-0 fw-bold text-dark">Bidan Siti Fatimah, S.Tr.Keb</h5>
        <p class="text-muted mb-0 small"><i class="fas fa-circle-notch fa-spin me-1" style="font-size: 8px;"></i> Online</p>
    </div>
</div>

        <div class="chat-messages">
            @forelse($pesans as $chat)
                @if($chat->sender == 'bumil')
                    <div class="row-bumil">
                        <div class="bubble bubble-bumil">
                            {{ $chat->pesan }}
                            <small class="d-block mt-1 opacity-75">{{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}</small>
                        </div>
                    </div>
                @else
                    <div class="row-bidan">
                        <div class="bubble bubble-bidan">
                            @if(($chat->tipe_pesan ?? 'text') == 'request_offline')
                                <p class="mb-2">Bunda disarankan untuk melakukan pemeriksaan offline.</p>
                                
                                @php
                                    $status = \DB::table('tb_pendaftaran')->where('user_id', auth()->id())->latest()->first()?->status_konsultasi;
                                @endphp

                                @if(!$status)
                                    <form action="{{ route('konsultasi.ajukan') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm text-white w-100" style="background:#F84F8F; border-radius:10px;">Ajukan Jadwal Offline</button>
                                    </form>
                                @elseif($status == 'menunggu')
                                    <button class="btn btn-sm btn-warning w-100" disabled>⏳ Menunggu Konfirmasi</button>
                                @else
                                    <button class="btn btn-sm btn-success w-100" disabled>✅ Sudah Terjadwal</button>
                                @endif
                            @else
                                {{ $chat->pesan }}
                            @endif
                            <small class="d-block mt-1 text-muted">{{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}</small>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center text-muted">Belum ada percakapan.</p>
            @endforelse
        </div>

        <div class="chat-footer">
            <form action="{{ route('bumil.konsultasi.kirim') }}" method="POST" class="w-100 d-flex">
                @csrf
                <input type="text" name="pesan" class="form-control rounded-pill me-2" placeholder="Tulis pesan..." required>
                <button type="submit" class="btn rounded-circle" style="background:#F84F8F; color:white;"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDataBidan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px;">
            <div class="modal-body p-0 text-center overflow-hidden">
                <div style="background: linear-gradient(135deg, #F84F8F, #ff9eb6); height: 120px;"></div>
                
                <img src="{{ asset('images/iconchatbidan.png') }}" class="rounded-circle border border-4 border-white shadow" 
                     style="width: 110px; height: 110px; margin-top: -60px; object-fit: cover;">
                
                <div class="p-4">
                    <h4 class="fw-bold mt-2">Bidan Siti Fatimah, S.Tr.Keb</h4>
                    <p class="text-pink fw-semibold" style="color: #F84F8F;">Bidan Profesional & Konsultan Bumil</p>
                    
                    <div class="row text-start mt-4 bg-light p-3 rounded-4 mx-0">
                        <div class="col-12 mb-2"><i class="fas fa-map-marker-alt me-2 text-pink"></i> Jl. Mastrip No. 5, Jember</div>
                        <div class="col-12 mb-2"><i class="fas fa-id-card me-2 text-pink"></i> SIP: SIP/2023/05/001</div>
                        <div class="col-12"><i class="fas fa-clock me-2 text-pink"></i> Senin - Jumat: 08.00 - 16.00</div>
                    </div>
                </div>
                
                <div class="p-3">
                    <button type="button" class="btn btn-secondary w-75 rounded-pill" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection