<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

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
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('assets/image/logo.png') }}" width="150" height="40">
    </div>

    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.index') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
        <i class="bi bi-people"></i> Users
    </a>

    <a class="nav-link {{ request()->routeIs('post.*') ? 'active' : '' }}" href="{{ route('post.index') }}">
        <i class="bi bi-file-earmark-text"></i> Posts
    </a>

    <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="/admin/settings"><i class="bi bi-gear"></i> Settings</a>

    <hr class="sidebar-divider">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-purple w-100 mt-2">
            <i class="fa-solid fa-right-to-bracket me-2"></i>Logout
        </button>
    </form>
</aside>

{{-- MAIN CONTENT --}}
<main class="main" id="main">
    <div class="topbar">
        <button class="btn d-lg-none" id="toggleSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="d-flex align-items-center ms-auto gap-3">
            <i class="bi bi-bell fs-5"></i>
            <img src="https://i.pravatar.cc/45" width="36" class="rounded-circle">
        </div>
    </div>

    @yield('content')
</main>

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
