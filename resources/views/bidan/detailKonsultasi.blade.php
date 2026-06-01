@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid chat-page">
    <h4 class="fw-bold page-title">Konsultasi Bidan</h4>

    <div class="row chat-wrapper g-4">

        {{-- SIDEBAR CHAT --}}
        <div class="col-md-4 chat-col">
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold nama-pasien">{{ $item->nama_pasien }}</span>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->waktu_terakhir)->format('H:i') }}
                                    </small>
                                </div>

                                <small class="text-muted d-block">
                                    Pesan konsultasi pasien
                                </small>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center p-4 text-muted">
                        Belum ada chat dari pasien.
                    </div>
                    @endforelse
                </div>

            </div>
        </div>

        {{-- ROOM CHAT --}}
        <div class="col-md-8 chat-col">
            <div class="card border-0 shadow-sm chat-card">

                {{-- HEADER --}}
                <div class="chat-header border-bottom">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pasien->name ?? 'Pasien') }}&background=f8b6d2&color=fff"
                        class="rounded-circle me-3" width="52" height="52">

                    <div>
                        <h6 class="fw-bold mb-0">{{ $pasien->name ?? 'Pasien' }}</h6>
                        <small class="text-success">Online</small>
                    </div>

                    <form action="{{ route('bidan.konsultasi.requestOffline', $user_id) }}" method="POST"
                        class="ms-auto">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-pink">
                            Request Konsultasi Offline
                        </button>
                    </form>
                </div>

                {{-- BODY CHAT --}}
                <div class="chat-body" id="chatBody">
                    @forelse ($pesans as $chat)

                    @if ($chat->sender == 'bumil')
                    <div class="message-left mb-3">
                        <div class="bubble-left">
                            {{ $chat->pesan }}
                        </div>
                        <div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                            </small>
                        </div>
                    </div>
                    @else
                    <div class="message-right mb-3 text-end">
                        <div class="bubble-right">
                            {{ $chat->pesan }}
                        </div>
                        <div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                            </small>
                        </div>
                    </div>
                    @endif

                    @empty
                    <div class="text-center text-muted mt-5">
                        Belum ada pesan.
                    </div>
                    @endforelse
                </div>

                {{-- INPUT CHAT --}}
                <div class="chat-footer border-top">
                    <form action="{{ route('bidan.konsultasi.kirim', $user_id) }}" method="POST"
                        class="d-flex align-items-center gap-2">
                        @csrf

                        <input type="text" name="pesan" class="form-control rounded-pill"
                            placeholder="Tulis pesan..." required>

                        <button type="submit" class="btn btn-send rounded-circle">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
html,
body {
    height: 100%;
    overflow: hidden;
}

.text-pink {
    color: #f26aa8;
}

.chat-page {
    height: auto;
    min-height: calc(100vh - 60px);
    padding: 15px 24px 20px 24px;
    overflow: hidden;
}

.page-title {
    margin: 0 0 18px 0;
}

.chat-wrapper {
    height: calc(100vh - 180px);
    overflow: hidden;
}

.chat-col {
    height: 100%;
    min-height: 0;
    display: flex;
}

.chat-list-card,
.chat-card {
    width: 100%;
    height: 100%;
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.chat-list-card .card-header,
.chat-header,
.chat-footer {
    flex-shrink: 0;
}

#searchChat {
    border-radius: 14px;
}

#chatList {
    flex: 1;
    min-height: 0;
    max-height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
}

.chat-header {
    background: #fff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
}

.chat-body {
    flex: 1;
    min-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
    background: #fff7fb;
    padding: 24px;
}

.chat-footer {
    background: #fff;
    padding: 10px 20px;
}

.chat-item {
    border-bottom: 1px solid #f3e3ea !important;
}

.chat-item:hover {
    background-color: #fff5fa;
}

.active-chat {
    background-color: #fff0f6 !important;
    border-left: 5px solid #f26aa8 !important;
}

.bubble-left {
    display: inline-block;
    background: white;
    padding: 13px 18px;
    border-radius: 18px 18px 18px 6px;
    max-width: 70%;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
    font-size: 15px;
}

.bubble-right {
    display: inline-block;
    background: #f26aa8;
    color: white;
    padding: 13px 18px;
    border-radius: 18px 18px 6px 18px;
    max-width: 70%;
    font-size: 15px;
}

.btn-pink {
    background: #f26aa8;
    color: white;
    border-radius: 20px;
    padding: 8px 16px;
}

.btn-pink:hover,
.btn-send:hover {
    background: #e85b9d;
    color: white;
}

.btn-send {
    background: #f26aa8;
    color: white;
    width: 42px;
    height: 42px;
}

/* SCROLL KIRI DAN KANAN */
#chatList::-webkit-scrollbar,
.chat-body::-webkit-scrollbar {
    width: 8px;
}

#chatList::-webkit-scrollbar-track,
.chat-body::-webkit-scrollbar-track {
    background: #f5f5f5;
    border-radius: 10px;
}

#chatList::-webkit-scrollbar-thumb,
.chat-body::-webkit-scrollbar-thumb {
    background: #bdbdbd;
    border-radius: 10px;
}

#chatList::-webkit-scrollbar-thumb:hover,
.chat-body::-webkit-scrollbar-thumb:hover {
    background: #8f8f8f;
}
</style>

<script>
document.getElementById('searchChat').addEventListener('keyup', function() {
    let keyword = this.value.toLowerCase();
    let chats = document.querySelectorAll('.chat-item');

    chats.forEach(function(item) {
        let namaPasien = item.querySelector('.nama-pasien').innerText.toLowerCase();

        if (namaPasien.includes(keyword)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

let chatBody = document.getElementById('chatBody');
if (chatBody) {
    chatBody.scrollTop = chatBody.scrollHeight;
}
</script>
@endsection