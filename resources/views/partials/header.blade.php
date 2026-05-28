<nav class="navbar navbar-expand-lg shadow-sm px-4" 
     style="margin-left: 250px; background-color: #f875aa; height: 70px; position: fixed; top: 0; right: 0; left: 0; z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white d-lg-none" href="#">Bumiloo</a>

        <form class="d-flex ms-auto me-3 d-none d-md-flex">
        </form>

        <div class="d-flex align-items-center">
            </div>
           <div class="d-flex align-items-center text-white"
     onclick="toggleProfileSidebar()" 
     style="cursor: pointer; user-select: none;">
    <span class="me-2 d-none d-sm-inline">{{ Auth::user()->name }}</span>
    <i class="fas fa-user-circle fs-4"></i>
</div>

@include('partials.settingsdropdown')
        </div>
    </div>
</nav>