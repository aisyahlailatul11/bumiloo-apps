@extends('layouts.masterBidan')

@section('content')

{{-- CONTAINER UTAMA --}}
<div class="chat-page">
    <div class="chat-wrapper">

        {{-- SIDEBAR CHAT --}}
        <div class="chat-col-sidebar">
            <div class="card border-0 shadow-sm chat-list-card">
                <div class="card-header bg-white border-0 p-3">
                    <h6 class="fw-bold mb-3 text-pink">Semua Chat</h6>
                    <input type="text" id="searchChat" class="form-control" placeholder="Cari pasien...">
                </div>

                <div class="list-group list-group-flush" id="chatList">
                    @forelse ($konsultasis as $item)
                        <a href="{{ route('bidan.konsultasi.detail', $item->user_id) }}"
                           class="list-group-item list-group-item-action border-0 py-3 chat-item {{ $user_id == $item->user_id ? 'active-chat' : '' }}">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama_pasien) }}&background=f8b6d2&color=fff"
                                     class="rounded-circle me-3" width="50" height="50">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold nama-pasien">{{ $item->nama_pasien }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->waktu_terakhir)->format('H:i') }}</small>
                                    </div>
                                    <small class="text-muted d-block">Pesan konsultasi pasien</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center p-4 text-muted">Belum ada chat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ROOM CHAT --}}
<div class="chat-col-room">
    {{-- CARD MENCAKUP SEMUA (Header, Body, Footer) --}}
    <div class="card border-0 shadow-sm chat-card h-100 d-flex flex-column overflow-hidden">
        
        {{-- 1. HEADER --}}
        <div class="chat-header border-bottom d-flex align-items-center p-3 bg-white">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($pasien->name ?? 'Pasien') }}&background=f8b6d2&color=fff"
                 class="rounded-circle me-3" width="50" height="50">
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-0">{{ $pasien->name ?? 'Pasien' }}</h6>
                <small class="text-success">Online</small>
            </div>
            
            <form action="{{ route('bidan.konsultasi.requestOffline', $user_id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-pink rounded-pill px-4">Request Offline</button>
            </form>
        </div>

        {{-- 2. BODY CHAT --}}
        <div class="chat-body flex-grow-1 overflow-auto p-4" id="chatBody">
            @forelse ($pesans as $chat)
                <div class="d-flex {{ $chat->sender == 'bumil' ? 'justify-content-start' : 'justify-content-end' }} mb-3">
                    <div class="{{ $chat->sender == 'bumil' ? 'bubble-left' : 'bubble-right' }}">
                        {{ $chat->pesan }}
                        <div class="text-end" style="font-size: 10px; opacity: 0.7; margin-top: 4px;">
                            {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted mt-5">Belum ada pesan.</div>
            @endforelse
        </div>

        {{-- 3. FOOTER INPUT (Sekarang di dalam card!) --}}
        <div class="chat-footer border-top bg-white p-3">
            <form action="{{ route('bidan.konsultasi.kirim', $user_id) }}" method="POST" class="d-flex align-items-center gap-2">
                @csrf
                <input type="text" 
                       name="pesan" 
                       class="form-control rounded-pill px-4" 
                       placeholder="Tulis pesan..." 
                       required>
                
                <button type="submit" 
                        class="btn btn-pink rounded-circle shadow-sm" 
                        style="width: 45px; height: 45px; min-width: 45px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-paper-plane" style="color: white;"></i>
                </button>
            </form>
        </div>

    </div> {{-- Penutup card yang benar --}}
</div>
<style>
/* Reset & Layout */
html, body { height: 100%; margin: 0; background-color: #fff0f6; overflow: hidden; }

/* Kurangi 100px untuk memberi ruang header aplikasi jika ada */
.chat-page { height: calc(100vh - 100px); padding: 20px; } 

.chat-wrapper { display: flex; height: 100%; gap: 20px; }
.chat-col-sidebar { width: 30%; height: 100%; }
.chat-col-room { width: 70%; height: 100%; }

/* Styling Card */
.chat-list-card, .chat-card { 
    height: 100%; 
    display: flex; 
    flex-direction: column; 
    border-radius: 25px; 
    overflow: hidden; 
    border: 1px solid #ffe4f0; 
}

/* KUNCI PERBAIKAN: Padding bawah agar chat terakhir tidak tertutup input */
.chat-body { 
    flex: 1; 
    overflow-y: auto; 
    padding: 30px; 
    padding-bottom: 60px; /* Tambahkan ruang di bawah */
    background-color: #fff5fa; 
    background-image: radial-gradient(#fcc2df 1px, transparent 1px); 
    background-size: 20px 20px; 
}

/* Pastikan footer tidak ikut scroll */
.chat-footer { flex-shrink: 0; }

/* Bubble Chat */
.message-left { display: flex; flex-direction: column; align-items: flex-start; }
.message-right { display: flex; flex-direction: column; align-items: flex-end; }
.bubble-left { background: #ffffff; padding: 12px 18px; border-radius: 18px 18px 18px 4px; border: 1px solid #ffe4f0; max-width: 70%; }
.bubble-right { background: #f26aa8; color: white; padding: 12px 18px; border-radius: 18px 18px 4px 18px; max-width: 70%; }

/* UI Elemen */
.text-pink { color: #f26aa8; }
.btn-pink { background: #f26aa8; color: white; }
.btn-send { background: #f26aa8; color: white; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
.form-control { border-radius: 25px !important; border: 1px solid #fcc2df; padding: 10px 20px; }

.active-chat { background-color: #fff0f6 !important; border-left: 5px solid #f26aa8 !important; }

chat-body::-webkit-scrollbar {
    display: none;
}

.chat-body {
    scrollbar-width: none;
}

.chat-body {
    -ms-overflow-style: none;
}
</style>

<script>
let chatBody = document.getElementById('chatBody');
if (chatBody) { chatBody.scrollTop = chatBody.scrollHeight; }
</script>
@endsection