@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid py-4">

    <h4 class="fw-bold mb-4">Konsultasi Bidan</h4>

    <div class="row">

        {{-- LIST CHAT --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm" style="border-radius:20px;">

                <div class="card-header bg-white border-0 py-3">

                    <h6 class="fw-bold text-pink mb-3">
                        Semua Chat
                    </h6>

                    <input type="text" id="searchChat" class="form-control" placeholder="Cari pasien..."
                        style="border-radius:12px;">

                </div>

                <div class="list-group list-group-flush" id="chatList">

                    @forelse ($konsultasis as $item)

                    <a href="{{ route('bidan.konsultasi.detail', $item->user_id) }}"
                        class="list-group-item list-group-item-action border-0 py-3 chat-item" <div
                        class="d-flex align-items-center">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama_pasien) }}&background=f8b6d2&color=fff"
                            class="rounded-circle me-3" width="50" height="50">

                        <div class="flex-grow-1">

                            <div class="d-flex justify-content-between">

                                <span class="fw-bold">
                                    {{ $item->nama_pasien }}
                                </span>

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

    {{-- HALAMAN AWAL CHAT --}}
    <div class="col-md-8">

        <div class="card border-0 shadow-sm h-100 d-flex align-items-center justify-content-center text-center"
            style="border-radius:20px; min-height:500px;">

            <div>

                <i class="fas fa-comments text-pink mb-3" style="font-size:70px;">
                </i>

                <h5 class="fw-bold">
                    Pilih salah satu percakapan
                </h5>

                <p class="text-muted mb-0">
                    Chat pasien akan muncul setelah pasien mengirim konsultasi.
                </p>

            </div>

        </div>

    </div>

</div>

</div>
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