<div id="profileSidebarOverlay" class="position-fixed inset-0 vh-100 vw-100 d-none" 
     style="top: 0; left: 0; background-color: rgba(0, 0, 0, 0.4); z-index: 1040; transition: opacity 0.3s ease;"
     onclick="toggleProfileSidebar()"></div>

<style>
    #profileSidebar::-webkit-scrollbar {
        display: none; /* Menyembunyikan batang scroll untuk Chrome, Safari, dan Opera */
    }
    #profileSidebar {
        -ms-overflow-style: none;  /* Menyembunyikan batang scroll untuk IE dan Edge */
        scrollbar-width: none;  /* Menyembunyikan batang scroll untuk Firefox */
    }
</style>

<div id="profileSidebar" class="position-fixed bg-white" 
     style="top: 20px; right: -380px; width: 350px; height: calc(100vh - 40px); z-index: 1050; transition: right 0.3s ease-in-out; border-radius: 24px; overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
    
    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
        <h5 class="fw-bold mb-0 text-gray-800" style="color: #1E3A5F;">Pengaturan & Profil</h5>
        <button type="button" class="btn-close shadow-none" onclick="toggleProfileSidebar()" style="cursor: pointer;"></button>
    </div>

   <div class="p-4">
    <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
        @csrf
        <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;" onchange="this.form.submit();">
    </form>

    <div class="d-flex flex-column align-items-center mb-4">
        <div class="profile-avatar-container mb-3 position-relative rounded-circle shadow-sm border border-2 p-1" 
             onclick="document.getElementById('avatarInput').click();" 
             style="cursor: pointer; background-color: #fff; transition: transform 0.2s ease;"
             onmouseover="this.style.transform='scale(1.05)'"
             onmouseout="this.style.transform='scale(1)'"
             title="Klik untuk mengubah foto">
            
            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=f875aa&color=fff&size=90' }}" 
                 class="rounded-circle" width="85" height="85" alt="Avatar" style="object-fit: cover;">
            
            <span class="position-absolute bottom-0 end-0 bg-pink text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                  style="background-color: #ff69b4; width: 26px; height: 26px; border: 2px solid white;">
                <i class="fas fa-camera" style="font-size: 10px;"></i>
            </span>
        </div>

        <button class="btn btn-sm text-white rounded-pill px-3 py-1 shadow-sm" 
                style="font-size: 12px; background-color: #ff69b4; border: none;" 
                onclick="document.getElementById('avatarInput').click();">
            Edit Profile ▼
        </button>
    </div>
        @if(auth()->user()->role === 'bumil')
            <div class="mb-4">
                @include('partials.pengaturanpasien')
            </div>
        @endif

        <div class="settings-menu-list mb-4">
            <h6 class="fw-bold px-1 mb-3 text-muted uppercase tracking-wider" style="font-size: 11px;">Pengaturan Sistem</h6>
            
            <div class="menu-item d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 border-0" 
     style="background-color: #dbdbdb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
    <span class="fw-bold text-dark">Mode malam</span>
    <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="darkModeSwitch" onclick="toggleDarkMode()" style="cursor: pointer;">
    </div>
</div>

            <a href="{{ route('pengaturan.keamanan') }}" class="menu-item d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 border-0 text-decoration-none text-dark transition-all"
   style="background-color: #dbdbdb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
   onmouseover="this.style.transform='translateY(-2px)';"
   onmouseout="this.style.transform='translateY(0)';">
    <span class="fw-bold text-dark">Keamanan</span> <i class="bi bi-chevron-right text-dark small fw-bold"></i>
</a>

<a href="{{ route('pengaturan.gantinomor') }}" class="menu-item d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 border-0 text-decoration-none text-dark transition-all"
   style="background-color: #dbdbdb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
   onmouseover="this.style.transform='translateY(-2px)';"
   onmouseout="this.style.transform='translateY(0)';">
    <span class="fw-bold text-dark">Ganti Nomor HP</span> <i class="bi bi-chevron-right text-dark small fw-bold"></i>
</a>

<a href="{{ route('pengaturan.bantuan') }}" class="menu-item d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 border-0 text-decoration-none text-dark transition-all"
   style="background-color: #dbdbdb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
   onmouseover="this.style.transform='translateY(-2px)';"
   onmouseout="this.style.transform='translateY(0)';">
    <span class="fw-bold text-dark">Pusat Bantuan</span> <i class="bi bi-chevron-right text-dark small fw-bold"></i>
</a>   
</div>

 <div class="other-menu-list border" style="background-color: #FFF0F3; border-radius: 16px; padding: 4px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
    <p class="text-center small fw-bold text-muted my-2 border-bottom pb-2" style="font-size: 11px; border-color: #FCD2D9 !important;">Tindakan Akun</p>
    

    <button type="button" onclick="confirmDeleteAccount()" class="w-100 btn text-start d-flex justify-content-between align-items-center py-2.5 px-3 text-danger fw-bold border-0 bg-transparent" style="font-size: 14px;">
        <span><i class="bi bi-trash me-2"></i> Hapus akun</span> <i class="bi bi-chevron-right small"></i>
    </button>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
</div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Anda akan keluar dari sesi ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff6b9a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
    // Fungsi Baru untuk Konfirmasi Hapus Akun
    function confirmDeleteAccount() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akun Anda akan terhapus secara permanen dari database dan tidak dapat dikembalikan!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Akun!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik 'Ya', submit form hapus akun
                document.getElementById('delete-account-form').submit();
            }
        })
    }
</script>

<script>
    function toggleProfileSidebar() {
        const sidebar = document.getElementById('profileSidebar');
        const overlay = document.getElementById('profileSidebarOverlay');
        
        if (sidebar.style.right === '20px') {
            sidebar.style.right = '-380px';
            overlay.classList.add('d-none');
        } else {
            sidebar.style.right = '20px';
            overlay.classList.remove('d-none');
        }
    }
</script>