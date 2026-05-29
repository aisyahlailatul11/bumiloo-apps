@extends('layouts.settingsMaster')

@section('setting_content')

<div class="container-fluid px-4 py-3">

    {{-- JUDUL --}}
    <h4 class="fw-bold" style="color:#f875aa;">Keamanan Akun</h4>
    <p class="text-muted small mb-4">Kelola informasi akun dan keamanan untuk menjaga data Anda tetap aman.</p>

    {{-- INFORMASI AKUN --}}
    <div class="mb-4">
        <h6 class="fw-bold mb-3">Informasi Akun</h6>

        {{-- USERNAME --}}
        <div class="card border-0 shadow-sm p-3 mb-3 d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:40px;height:40px;background:#fff0f6;">
                    <i class="fas fa-user" style="color:#f875aa;"></i>
                </div>
                <div>
                    <small class="text-muted">Username</small>
                    <div class="fw-semibold">{{ auth()->user()->username ?? auth()->user()->name }}</div>
                </div>
            </div>
        </div>

        {{-- EMAIL --}}
        <div class="card border-0 shadow-sm p-3 mb-2 d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:40px;height:40px;background:#fff0f6;">
                    <i class="fas fa-envelope" style="color:#f875aa;"></i>
                </div>
                <div>
                    <small class="text-muted">Email</small>
                    <div class="fw-semibold">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <button class="btn btn-sm" style="color:#f875aa;" onclick="toggleEmail()">
                <i class="fas fa-pen me-1"></i> Ubah
            </button>
        </div>

        {{-- Form Ganti Email --}}
        <div id="formEmail" class="d-none mt-2 card border-0 shadow-sm p-4 mb-3">
            @if(session('success_email'))
                <div class="alert alert-success small">{{ session('success_email') }}</div>
            @endif
            <form method="POST" action="{{ route('pengaturan.updateEmail') }}">
                @csrf
                <label class="form-label small fw-semibold">Email Baru</label>
                <input type="email" name="email" class="form-control mb-3"
                    placeholder="Masukkan email baru" value="{{ auth()->user()->email }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary"
                        onclick="toggleEmail()">Batal</button>
                    <button type="submit" class="btn text-white px-4"
                        style="background:#f875aa;">Simpan Email</button>
                </div>
            </form>
        </div>
    </div>

    {{-- GANTI PASSWORD --}}
    <div class="mb-4">
        <h6 class="fw-bold mb-1">Ganti Password</h6>
        <p class="text-muted small mb-3">Perbarui password secara berkala untuk menjaga keamanan akun Anda.</p>

        <div class="card border-0 shadow-sm">
            {{-- ACCORDION HEADER --}}
            <div class="p-3 d-flex align-items-center justify-content-between"
                style="cursor:pointer;" onclick="togglePassword()">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-lock" style="color:#f875aa;"></i>
                    <span class="fw-semibold">Ubah Password</span>
                </div>
                <i class="fas fa-chevron-up" id="iconChevron"></i>
            </div>

            {{-- FORM PASSWORD --}}
            <div id="formPassword" class="px-4 pb-4">
                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger small">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('pengaturan.updatePassword') }}">
                    @csrf

                    {{-- PASSWORD LAMA --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="currentPassword"
                                class="form-control" placeholder="Masukkan password lama">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="toggleVisibility('currentPassword', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- PASSWORD BARU --}}
                    <div class="mb-1">
                        <label class="form-label small fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="newPassword"
                                class="form-control" placeholder="Masukkan password baru"
                                oninput="checkStrength(this.value)">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="toggleVisibility('newPassword', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="confirmPassword"
                                class="form-control" placeholder="Masukkan ulang password baru">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="toggleVisibility('confirmPassword', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- KEKUATAN PASSWORD --}}
                    <div class="mb-3">
                        <small class="fw-semibold">Kekuatan Password: </small>
                        <div class="d-flex gap-2 mt-1 align-items-center">
                            <div class="progress flex-grow-1" style="height:6px;">
                                <div id="strengthBar" class="progress-bar" style="width:0%; background:#f875aa;"></div>
                            </div>
                            <small id="strengthText" style="color:#f875aa;">Lemah</small>
                        </div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4"
                            onclick="togglePassword()">Batal</button>
                        <button type="submit" class="btn px-4 text-white"
                            style="background:#f875aa;">Simpan Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const form = document.getElementById('formPassword');
    const icon = document.getElementById('iconChevron');
    form.classList.toggle('d-none');
    icon.classList.toggle('fa-chevron-up');
    icon.classList.toggle('fa-chevron-down');
}

function toggleEmail() {
    document.getElementById('formEmail').classList.toggle('d-none');
}

function toggleVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function checkStrength(val) {
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const levels = [
        { w: '25%', label: 'Lemah', color: '#ef4444' },
        { w: '50%', label: 'Cukup', color: '#f97316' },
        { w: '75%', label: 'Kuat', color: '#eab308' },
        { w: '100%', label: 'Sangat Kuat', color: '#22c55e' },
    ];
    const l = levels[Math.max(0, strength - 1)] || levels[0];
    bar.style.width = val.length ? l.w : '0%';
    bar.style.background = l.color;
    text.textContent = val.length ? l.label : 'Lemah';
    text.style.color = l.color;
}
</script>

@endsection