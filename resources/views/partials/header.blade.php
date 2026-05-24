<nav class="navbar navbar-expand-lg shadow-sm px-4" 
     style="margin-left: 250px; background-color: #f875aa; height: 70px; position: fixed; top: 0; right: 0; left: 0; z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white d-lg-none" href="#">Bumiloo</a>

        <form class="d-flex ms-auto me-3 d-none d-md-flex">
            <input class="form-control border-0 rounded-pill px-3" type="search" placeholder="Cari data..." aria-label="Search" style="background-color: white; color: white;">
        </form>

        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fas fa-bell fs-5 text-white cursor-pointer"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">3</span>
            </div>
           <div class="border-start ps-3 ms-2 d-flex align-items-center text-white" 
     onclick="toggleProfileSidebar()" 
     style="cursor: pointer; user-select: none;">
    <span class="me-2 d-none d-sm-inline">{{ Auth::user()->name }}</span>
    <i class="fas fa-user-circle fs-4"></i>
</div>

@include('partials.settingsdropdown')
        </div>
    </div>
</nav>