@extends($role === 'Admin' ? 'layouts.masterAdmin' : ($role === 'Bidan' ? 'layouts.masterBidan' : 'layouts.masterBumil'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
                <h5 class="fw-bold mb-3 px-2">Pengaturan</h5>
                <div class="list-group list-group-flush">
                    <a href="{{ route('pengaturan.keamanan') }}" class="list-group-item list-group-item-action border-0 {{ request()->routeIs('pengaturan.keamanan') ? 'active rounded' : '' }}">Keamanan</a>
                    <a href="{{ route('pengaturan.gantinomor') }}" class="list-group-item list-group-item-action border-0 {{ request()->routeIs('pengaturan.gantinomor') ? 'active rounded' : '' }}">Ganti Nomor HP</a>
                    <a href="{{ route('pengaturan.bantuan') }}" class="list-group-item list-group-item-action border-0 {{ request()->routeIs('pengaturan.bantuan') ? 'active rounded' : '' }}">Pusat Bantuan</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; min-height: 400px;">
                @yield('setting_content')
            </div>
        </div>
    </div>
</div>
@endsection