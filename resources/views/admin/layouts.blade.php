<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

    <title>@yield('title') - Pagee Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/style-admin.css') }}" rel="stylesheet">
</head>

<body>

<div id="overlay"></div>
{{-- SIDEBAR --}}
<div class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/image/logo.png') }}" width="150" height="40">
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>

        <!-- Posts Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.post.*') ? '' : 'collapsed' }}" href="#postSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.post.*') ? 'true' : 'false' }}">
                <span><i class="bi bi-file-earmark-text"></i> Posts</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.post.*') ? 'show' : '' }}" id="postSubmenu">
                <ul class="nav flex-column ms-3">                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.post*') && !request()->routeIs('admin.post.anonim*') && !request()->routeIs('admin.post.chapter*') ? 'active' : '' }}" href="{{ route('admin.post.index') }}">Short</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.post.anonim*') ? 'active' : '' }}" href="{{ route('admin.post.anonim') }}">Anonim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.post.chapter*') ? 'active' : '' }}" href="{{ route('admin.post.chapter') }}">Chapter</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="/admin/settings">
                <i class="bi bi-gear"></i> Settings
            </a>
        </li>
        <hr class="sidebar-divider">

<form action="{{ route('logout') }}" method="POST" class="px-3 mt-2">
    @csrf
    <button type="submit" class="btn btn-purple w-100 d-flex align-items-center justify-content-center">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
    </button>
</form>

<style>
.btn-purple {
    background-color: #6f42c1;  /* Ungu */
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 0;
    font-weight: 500;
    transition: 0.2s;
}
.btn-purple:hover {
    background-color: #5931a3; /* Ungu lebih gelap */
    color: #fff;
}
/* TOPBAR FIX / STICKY */
.topbar {
    position: sticky;
    top: 0;
    z-index: 1030; /* di atas konten */
    background: #fff;
    border-bottom: 1px solid #eee;
    padding: 12px 20px;
}

/* Biar konten nggak ketiban */
.main {
    padding-top: 0; /* sticky tidak butuh offset */
}

</style>

    </ul>
</div>

{{-- MAIN CONTENT --}}
<main class="main" id="main">
    <div class="topbar">
        <button class="btn d-lg-none" id="toggleSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="d-flex align-items-center ms-auto gap-3">
            <img src="https://i.pravatar.cc/45" width="36" class="rounded-circle">
        </div>
    </div>

    @yield('content')
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('toggleSidebar');
    const overlay = document.getElementById('overlay');

    function openSidebar(){
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }
    function closeSidebar(){
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    toggle?.addEventListener('click', ()=> openSidebar());
    overlay?.addEventListener('click', ()=> closeSidebar());
</script>
@stack('custom-js')

</body>
</html>
