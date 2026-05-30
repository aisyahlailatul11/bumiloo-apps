@extends('layouts.masterAdmin')

@section('title', 'Data Detail Bidan - Bumiloo')

@section('content')
{{-- Google Fonts Poppins & Alpine.js Standalone --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    .bdn-f-container * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box !important; }
    
    /* INDUK CARD UTAMA: Dikunci mati radius 32px dan TIDAK BOLEH SCROLL DI SINI */
    .bdn-f-card { 
        background-color: #FFFFFF !important; 
        border-radius: 32px !important; 
        border: 1px solid #E2E8F0 !important; 
        box-shadow: 0 20px 25px -5px rgba(219, 234, 254, 0.6), 0 10px 10px -5px rgba(219, 234, 254, 0.6) !important; 
        overflow: hidden !important; /* Memotong paksa elemen dalam agar bulat sempurna */
        margin-top: 24px;
        width: 100% !important;
    }
    
    /* SUB HEADER: Dikunci mati posisinya, gak bakal ikut geser/hilang pas di-scroll */
    .bdn-f-header { 
        padding: 24px 40px !important; 
        border-bottom: 1px solid #E2E8F0 !important; 
        display: flex !important; 
        justify-content: space-between !important; 
        align-items: center !important; 
        background-color: #FFFFFF !important;
        width: 100% !important;
        position: relative !important;
        z-index: 20 !important;
    }
    
    /* PEMBUNGKUS SCROLL KHUSUS KONTEN: Biar kalau layar kekecilan, yang scroll CUMA grid bawah ini aja! */
    .bdn-f-scroll-wrapper {
        width: 100% !important;
        overflow-x: auto !important; /* Efek scroll diisolasi hanya di sini, Syah! */
    }
    
    /* Grid System Kanan Kiri Sejajar Figma */
    .bdn-f-grid { 
        padding: 48px !important; 
        display: grid !important; 
        grid-template-columns: 1fr !important; 
        gap: 32px !important; 
        position: relative !important;
        min-width: 900px !important; /* Menjaga layout kanan-kiri tetep tegak pas di-scroll */
    }
    @media (min-width: 768px) {
        .bdn-f-grid { grid-template-columns: 1fr 1fr !important; gap: 64px !important; }
        .bdn-f-divider { position: absolute !important; top: 48px !important; bottom: 48px !important; left: 50% !important; width: 1px !important; background-color: #F1F5F9 !important; transform: translateX(-50%) !important; }
    }

    /* Gaya Field Input Figma */
    .bdn-f-group { margin-bottom: 20px; }
    .bdn-f-label { font-size: 11px !important; font-weight: 700 !important; color: #94A3B8 !important; tracking: 0.15em !important; display: block !important; margin-bottom: 4px; text-transform: uppercase !important; }
    .bdn-f-value { font-size: 15px !important; font-weight: 600 !important; color: #1E293B !important; margin: 0 !important; padding: 6px 0 !important; }
    
    .bdn-f-input { width: 100% !important; background-color: #F8FAFC !important; border: 1px solid #E2E8F0 !important; border-radius: 12px !important; padding: 8px 14px !important; font-size: 14px !important; font-weight: 600 !important; color: #334155 !important; transition: 0.2s !important; outline: none !important; }
    .bdn-f-input:focus { border-color: #F875AA !important; background-color: #FFFFFF !important; }

    /* TOMBOL EDIT PROFIL (PINK KHAS BUMILOO + SEJAJAR ICON) */
.btn-figma-pink {
    background-color: #F875AA !important;
    color: #FFFFFF !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    padding: 10px 22px !important;
    border-radius: 10px !important;
    border: none !important;
    cursor: pointer !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    transition: 0.2s !important;
}
.btn-figma-pink:hover {
    background-color: #e05e93 !important;
}

/* TOMBOL BATAL (SAAT MODUL EDIT AKTIF) */
.btn-figma-batal {
    background-color: #94A3B8 !important;
    color: #FFFFFF !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    padding: 10px 22px !important;
    border-radius: 10px !important;
    border: none !important;
    cursor: pointer !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    transition: 0.2s !important;
}

/* TOMBOL SIMPAN MATI (DISABLED / ABU-ABU) */
.btn-figma-simpan {
    background-color: #E2E8F0 !important;
    color: #A0AEC0 !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    padding: 10px 22px !important;
    border-radius: 10px !important;
    border: 1px solid #D2D6DC !important;
    cursor: not-allowed !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
}

/* 🔥 TOMBOL SIMPAN AKTIF (BERUBAH JADI HIJAU MINT CERAH KHAS BUMILOO) */
.btn-figma-simpan-aktif {
    background-color: #F875AA !important; /* Hijau figma sukses */
    color: #FFFFFF !important;
    border-color: #F875AA !important;
    cursor: pointer !important;
    box-shadow: 0 4px 12px rgba(74, 222, 128, 0.2) !important;
}
.btn-figma-simpan-aktif:hover {
    background-color: #F875AA !important;
}
</style>

<div class="bdn-f-container w-full" style="padding: 20px; background-color: #ffffff; min-height: 100vh;">
    <div style="max-w: 1024px; margin: 0 auto;">

        <h1 style="font-size: 28px; font-weight: 700; color: #0F172A; margin: 0 0 20px 0;">Data Bidan</h1>

        <form action="{{ route('bidan.update', $b->id) }}" method="POST" enctype="multipart/form-data"
              x-data= "{ isEditing: false, photoPreview: '{{ asset('images/profil-bidan.jpeg') }}' }">
            @csrf

            <div class="bdn-f-card">
                
                <div class="bdn-f-header">
    <span style="color: #94A3B8; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.2em;">Profil Bidan</span>
    
    <div style="display: flex; gap: 12px; align-items: center;">
        
        <button type="button" @click="isEditing = !isEditing" :class="isEditing ? 'btn-figma-batal' : 'btn-figma-pink'">
            <svg x-show="!isEditing" xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            <svg x-show="isEditing" x-cloak xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span x-text="isEditing ? 'Batal' : 'Edit Profil'"></span>
        </button>

        <button type="submit" :disabled="!isEditing" :class="isEditing ? 'btn-figma-simpan btn-figma-simpan-aktif' : 'btn-figma-simpan'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            <span>Simpan</span>
        </button>
        
    </div>
</div>

                <div class="bdn-f-scroll-wrapper">
                    <div class="bdn-f-grid">
                        <div class="bdn-f-divider"></div>
                        
                        <div>
                            <div style="display: flex; align-items: center; gap: 24px; margin-bottom: 32px; border-bottom: 1px solid #F1F5F9; padding-bottom: 24px;">
                                <div style="position: relative; flex-shrink: 0;">
                                    <div style="width: 112px; height: 112px; border: 6px solid white; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); background-color: #F8FAFC; border-radius: 50%;">
                                        <img :src="photoPreview" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <label x-show="isEditing" x-cloak style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.4); border-radius: 50%; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px; width: 24px; color: white;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        </svg>
                                        <input type="file" name="foto" style="display: none;" @change="const file = $event.target.files[0]; if (file) { photoPreview = URL.createObjectURL(file) }">
                                    </label>
                                </div>
                                <div style="flex: 1;">
                                    <div style="margin-bottom: 12px;">
                                        <span class="bdn-f-label">ID Bidan</span>
                                        <p style="font-size: 16px; font-weight: 700; color: #1E293B; margin: 2px 0 0 0;">B001</p>
                                    </div>
                                    <div>
                                        <span class="bdn-f-label">Nama Bidan</span>
                                        <div x-show="!isEditing" class="bdn-f-value" style="font-size: 18px !important; font-weight: 800 !important; color: #1E3A5F !important;">{{ $b->nama }}</div>
                                        <input x-show="isEditing" x-cloak type="text" name="nama" value="{{ old('nama', $b->nama) }}" class="bdn-f-input">
                                    </div>
                                </div>
                            </div>

                            <div class="bdn-f-group">
                                <span class="bdn-f-label">Status Praktik</span>
                                <p x-show="!isEditing" class="bdn-f-value">{{ $b->status }}</p>
                               <input x-show="isEditing" x-cloak type="text" name="status" value="{{ old('status', $b->status) }}" class="bdn-f-input">
                            </div>

                            <div class="bdn-f-group">
                                <span class="bdn-f-label">NIP</span>
                                <p x-show="!isEditing" class="bdn-f-value">{{ $b->nip }}</p>
                                <input x-show="isEditing" x-cloak type="text" name="nip" value="{{ old('nip', $b->nip) }}" class="bdn-f-input">
                            </div>

                            <div class="bdn-f-group">
                                <span class="bdn-f-label">SIP (Surat Izin Praktik)</span>
                                <p x-show="!isEditing" class="bdn-f-value">{{ $b->sip }}</p>
                                <input x-show="isEditing" x-cloak type="text" name="sip" value="{{ old('sip', $b->sip) }}" class="bdn-f-input">
                            </div>

                            <div class="bdn-f-group">
                                <span class="bdn-f-label">Profil Singkat & Layanan</span>
                                <p x-show="!isEditing" class="bdn-f-value" style="line-height: 1.6; color: #475569;">{{ $b->profil_singkat }}</p>
                                <textarea x-show="isEditing" x-cloak name="profil_singkat" class="bdn-f-input" rows="3">{{ old('profil_singkat', $b->profil_singkat) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <div style="margin-bottom: 32px;">
                                <h4 style="font-size: 14px; font-weight: 800; color: #1E3A5F; text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 4px; height: 16px; background-color: #E2E8F0; border-radius: 99px; display: inline-block;"></span>Kontak
                                </h4>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">No. HP</span>
                                    <p x-show="!isEditing" class="bdn-f-value">{{ $b->no_hp }}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="no_hp" value="{{ old('no_hp', $b->no_hp) }}" class="bdn-f-input">
                                </div>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">Email</span>
                                    <p x-show="!isEditing" class="bdn-f-value">{{ $b->email }}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="email" value="{{ old('email', $b->email) }}" class="bdn-f-input">
                                </div>
                            </div>

                            <div>
                                <h4 style="font-size: 14px; font-weight: 800; color: #1E3A5F; text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 4px; height: 16px; background-color: #E2E8F0; border-radius: 99px; display: inline-block;"></span>Detail Praktik Mandiri
                                </h4>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">Alamat Praktik Mandiri</span>
                                    <p x-show="!isEditing" class="bdn-f-value">{{ $b->alamat_praktik }}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="alamat_praktik" value="{{ old('alamat_praktik', $b->alamat_praktik) }}" class="bdn-f-input">
                                </div>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">Status Akreditasi TPMB</span>
                                    <p x-show="!isEditing" class="bdn-f-value" style="color: #F875AA; font-weight: 700;">{{$b->status_akreditasi}}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="status_akreditasi" value="{{ old('status_akreditasi', $b->status_akreditasi) }}" class="bdn-f-input">
                                </div>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">Jadwal Praktik</span>
                                    <p x-show="!isEditing" class="bdn-f-value">{{$b->jadwal_praktik}}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="jadwal_praktik" value="{{ old('jadwal_praktik', $b->jadwal_praktik) }}" class="bdn-f-input">
                                </div>
                                <div class="bdn-f-group">
                                    <span class="bdn-f-label">Detail Tambahan</span>
                                    <p x-show="!isEditing" class="bdn-f-value">{{$b->detail_tambahan}}</p>
                                    <input x-show="isEditing" x-cloak type="text" name="detail_tambahan" value="{{ old('detail_tambahan', $b->detail_tambahan) }}" class="bdn-f-input">
                                </div>
                            </div>
                        </div>

                    </div>
                </div> </div>
        </form>
    </div>
</div>
@endsection