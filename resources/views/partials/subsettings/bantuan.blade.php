@extends('layouts.settingsMaster')

@section('setting_content')
<div class="container py-4 text-center">
    <h4 class="fw-bold mb-4" style="color: #ff6b9a;">Pusat Bantuan</h4>
    
    <h5 class="fw-bold mb-3">Memiliki Pertanyaan? Hubungi Kami Sekarang</h5>
    <p class="text-muted mb-5">Jika Anda masih memiliki pertanyaan seputar Bumiloo, Anda dapat menghubungi kami melalui:</p>

    <div class="d-flex flex-column align-items-center gap-3">
        
        <a href="https://wa.me/6285602778748" target="_blank" 
   class="btn text-white px-4 py-3 shadow-sm d-flex align-items-center transition-all" 
   style="background-color: #ff6b9a; border-radius: 15px; width: 350px; text-decoration: none; transition: 0.3s;">
    <i class="bi bi-telephone-fill me-3 fs-4"></i>
    <div class="text-start">
        <div class="fw-bold">Contact Support</div>
        <small>Senin-Jum'at (08.00-17.00)</small>
    </div>
</a>

        <a href="https://www.google.com/maps/search/?api=1&query=Mastrip+IV+Jember" target="_blank"
           class="btn text-white px-4 py-3 shadow-sm d-flex align-items-center transition-all" 
           style="background-color: #ff6b9a; border-radius: 15px; width: 350px; text-decoration: none; transition: 0.3s;">
            <i class="bi bi-geo-alt-fill me-3 fs-4"></i>
            <div class="text-start">
                <div class="fw-bold">Lokasi</div>
                <small>Mastrip IV, Blok, Jember</small>
            </div>
        </a>
        
    </div>
</div>

<style>
    .transition-all:hover {
        background-color: #e05c86 !important; /* Warna sedikit lebih gelap saat di-hover */
        transform: translateY(-2px);
    }
</style>
@endsection