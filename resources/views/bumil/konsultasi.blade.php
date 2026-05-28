@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-4">

    <h4 class="fw-bold mb-4">Konsultasi Bidan</h4>

    <div class="row">

        {{-- PROFILE BIDAN --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body text-center">

                    <div class="mb-3">
                        <img src="https://ui-avatars.com/api/?name=Bidan&background=f9a8d4&color=fff"
                            class="rounded-circle" width="110" height="110">
                    </div>

                    <h5 class="fw-bold text-pink">Bidan Praktik</h5>

                    <span class="badge bg-success mb-4">
                        Online
                    </span>

                    <div class="p-3 rounded-4" style="background:#fde8f2;">
                        <h6 class="fw-bold text-pink mb-2">
                            Jadwal Praktik
                        </h6>

                        <p class="mb-0 text-muted">
                            Setiap Hari <br>
                            08.00 - 16.00 WIB
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- CHAT --}}
        <div class="col-md-8">

            <div class="card border-0 shadow-sm" style="border-radius:20px; height:75vh;">

                {{-- HEADER CHAT --}}
                <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3"
                    style="border-radius:20px 20px 0 0;">

                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=Bidan&background=f9a8d4&color=fff"
                            class="rounded-circle me-3" width="45">

                        <div>
                            <h6 class="fw-bold mb-0">Bidan Praktik</h6>

                            <small class="text-success">
                                Online
                            </small>
                        </div>
                    </div>

                    <a href="{{ route('bumil.dashboard') }}" class="btn btn-outline-danger btn-sm">
                        Akhiri Chat
                    </a>
                </div>

                {{-- ISI CHAT --}}
                <div class="card-body overflow-auto" style="background:#fff5f8;">

                    @forelse($pesans as $chat)

                    {{-- CHAT BUMIL --}}
                    @if($chat->sender == 'bumil')

                    <div class="d-flex justify-content-end mb-3">

                        <div class="p-3 text-dark" style="
                                    max-width:70%;
                                    background:#fbcfe8;
                                    border-radius:18px 18px 0 18px;
                                ">

                            <p class="mb-1">
                                {{ $chat->pesan }}
                            </p>

                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                            </small>

                        </div>

                    </div>

                    {{-- CHAT BIDAN --}}
                    @else

                    <div class="d-flex justify-content-start mb-3">

                        <div class="p-3 bg-white border" style="
                                    max-width:70%;
                                    border-radius:18px 18px 18px 0;
                                ">

                            <p class="mb-1">
                                {{ $chat->pesan }}
                            </p>

                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                            </small>

                        </div>

                    </div>

                    @endif

                    @empty

                    <div class="text-center text-muted mt-5">
                        Belum ada pesan konsultasi
                    </div>

                    @endforelse

                </div>

                {{-- FORM CHAT --}}
                <div class="card-footer bg-white border-0">

                    <form action="{{ route('bumil.konsultasi.kirim') }}" method="POST">

                        @csrf

                        <div class="d-flex align-items-center gap-2">

                            <input type="text" name="pesan" class="form-control" placeholder="Ketik pesan....." required
                                style="border-radius:14px;">

                            <button type="submit" class="btn text-white" style="
                                    background:#ec4899;
                                    border-radius:14px;
                                    width:50px;
                                    height:50px;
                                ">

                                <i class="fa fa-paper-plane"></i>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection