@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-4">Konsultasi Bidan</h4>

    <div class="row">

        {{-- SIDEBAR CHAT --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-2 text-pink">Semua Chat</h6>
                    <input type="text" id="searchChat" class="form-control" placeholder="Cari pasien..."
                        style="border-radius:12px;">
                </div>

                <div class="list-group list-group-flush" id="chatList">
                    @forelse ($konsultasis as $item)
                    <a href="{{ route('bidan.konsultasi.detail', $item->user_id) }}"
                        class="list-group-item list-group-item-action border-0 py-3 chat-item {{ $user_id == $item->user_id ? 'active-chat' : '' }}">

                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama_pasien) }}&background=f8b6d2&color=fff"
                                class="rounded-circle me-3" width="45" height="45">

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">{{ $item->nama_pasien }}</span>

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
        <div class="col-md-8">
            <div class="card border-0 shadow-sm chat-card" style="border-radius:20px;">

                {{-- HEADER --}}
                <div class="chat-header border-bottom p-3 d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pasien->name ?? 'Pasien') }}&background=f8b6d2&color=fff"
                        class="rounded-circle me-3" width="50" height="50">

                    <div>
                        <h6 class="fw-bold mb-0">
                            {{ $pasien->name ?? 'Pasien' }}
                        </h6>
                        <small class="text-success">Online</small>
                    </div>

                    <form action="{{ route('bidan.konsultasi.requestOffline', $user_id) }}" method="POST"
                        class="ms-auto">

                        @csrf

                        <button type="submit" class="btn btn-sm text-white"
                            style="background:#f687b3; border-radius:12px;">
                            Request Konsultasi Offline
                        </button>
                    </form>
                </div>

                {{-- BODY CHAT --}}
                <div class="chat-body p-4">
                    @forelse ($pesans as $chat)

                    @if ($chat->sender == 'bumil')
                    <div class="message-left mb-3">
                        <div class="bubble-left">
                            {{ $chat->pesan }}
                        </div>
                        <br>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        </small>
                    </div>
                    @else
                    <div class="message-right mb-3 text-end">
                        <div class="bubble-right">
                            {{ $chat->pesan }}
                        </div>
                        <br>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                        </small>
                    </div>
                    @endif

                    @empty
                    <div class="text-center text-muted mt-5">
                        Belum ada pesan.
                    </div>
                    @endforelse
                </div>

                {{-- INPUT CHAT --}}
                <div class="chat-footer border-top p-3">
                    <form action="{{ route('bidan.konsultasi.kirim', $user_id) }}" method="POST"
                        class="d-flex align-items-center">
                        @csrf

                        <input type="text" name="pesan" class="form-control rounded-pill me-2"
                            placeholder="Tulis pesan..." required>

                        <button type="submit" class="btn text-white rounded-circle" style="background-color:#f687b3;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.active-chat {
    background-color: #fff0f6 !important;
    border-left: 5px solid #f687b3 !important;
}

.chat-card {
    height: calc(100vh - 170px);
    display: flex;
    flex-direction: column;
}

.chat-body {
    flex: 1;
    overflow-y: auto;
    background-color: #fafafa;
}

.chat-header,
.chat-footer {
    flex-shrink: 0;
}

.bubble-left {
    display: inline-block;
    background-color: white;
    padding: 12px 16px;
    border-radius: 18px 18px 18px 5px;
    max-width: 70%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.bubble-right {
    display: inline-block;
    background-color: #f687b3;
    color: white;
    padding: 12px 16px;
    border-radius: 18px 18px 5px 18px;
    max-width: 70%;
}
</style>
<script>
document.getElementById('searchChat').addEventListener('keyup', function() {

    let keyword = this.value.toLowerCase();

    let chats = document.querySelectorAll('.chat-item');

    chats.forEach(function(item) {

        let text = item.innerText.toLowerCase();

        if (text.includes(keyword)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }

    });

});
</script>
@endsection