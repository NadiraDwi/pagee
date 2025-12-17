<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pagee')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

    {{-- Custom Style --}}
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">

    @stack('styles')

    <style>
        /* ===== DESKTOP ACTIVE LINK ===== */
        .sidebar-link.active {
            color: #7b2cbf !important;
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: #7b2cbf !important;
        }

        /* ===== MOBILE SIDEBAR ===== */
        .mobile-sidebar {
            position: fixed;
            inset: 0;
            width: 250px;
            background: #fff;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            padding: 20px;
            overflow-y: auto;
        }

        .mobile-sidebar.show {
            transform: translateX(0);
        }

        .mobile-sidebar .sidebar-link {
            display: block;
            padding: 10px 0;
            color: #333;
            font-weight: 500;
            text-decoration: none;
        }

        .mobile-sidebar .sidebar-link.active {
            color: #7b2cbf;
            font-weight: 600;
        }

        /* Overlay */
        .mobile-sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1040;
            display: none;
        }

        .mobile-sidebar-overlay.show {
            display: block;
        }

        body.darken {
            overflow: hidden;
        }

        /* Dark Mode */
        body.dark-mode {
            background: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .sidebar-left {
            background: #1f1f1f;
        }

        body.dark-mode .sidebar-left a,
        body.dark-mode .sidebar-left a.sidebar-link {
            color: #ccc;
        }

        body.dark-mode .sidebar-left a.sidebar-link.active {
            color: #bb86fc;
        }

        body.dark-mode .navbar,
        body.dark-mode .mobile-sidebar {
            background: #1f1f1f !important;
        }

        body.dark-mode .navbar .text-dark,
        body.dark-mode .mobile-sidebar .sidebar-link {
            color: #ccc !important;
        }

        body.dark-mode .btn-purple {
            background: #7b2cbf;
            color: white;
        }

        body.dark-mode .btn-outline-purple {
            border-color: #bb86fc;
            color: #bb86fc;
        }
    </style>
</head>

<body>

    <!-- ===== SIDEBAR KIRI (DESKTOP) ===== -->
    <aside class="sidebar-left d-none d-md-block">
        <div class="sidebar-top">

            <h3 class="brand fw-bold text-purple fs-4 mb-4">Pagee<span class="dot">.</span></h3>

            <ul class="list-unstyled mb-3">
                <li>
                    <a href="{{ route('home') }}" class="sidebar-link @yield('nav-home')">
                        <i class="fa-solid fa-house me-2"></i>Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('whisper.index') }}" class="sidebar-link @yield('nav-whisper')">
                        <i class="fa-regular fa-comment-dots me-2"></i>Whisper
                    </a>
                </li>
                <li>
                    <a href="{{ route('chapter') }}" class="sidebar-link @yield('nav-chapter')">
                        <i class="fa-solid fa-book-open me-2"></i>Books
                    </a>
                </li>
            </ul>

        </div>

        <div class="sidebar-bottom">
            <hr class="sidebar-divider">

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-purple w-100 mt-2">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-purple w-100 mt-2">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                </a>
            @endguest
        </div>
    </aside>

    <!-- ===== NAVBAR (DESKTOP) ===== -->
    <nav class="navbar navbar-light bg-white shadow-sm fixed-top navbar-shift px-4 d-none d-md-flex">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <form class="d-flex align-items-center search-bar" action="{{ route('search') }}" method="GET">
                <span class="input-group-text border-0 bg-transparent pe-2">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input class="form-control border-0 shadow-none" type="search" name="q" placeholder="Cari di Pagee...">
            </form>

            <div class="d-flex align-items-center">
                <button id="modeToggle" class="btn btn-link text-dark fs-4 p-0" title="Ubah tema">
                    <i class="fa-solid fa-moon"></i>
                </button>

                @auth
                    <a href="{{ route('profile.show') }}" class="btn btn-link text-dark fs-4 p-0 ms-2" title="Profil">
                        <i class="fa-solid fa-user profile-icon"></i>
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-link text-dark fs-4 p-0 ms-2" title="Login">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                @endguest
            </div>

        </div>
    </nav>

    <!-- ===== MAIN LAYOUT ===== -->
    <div class="main-layout">

        <!-- ===== CONTENT (diisi halaman child) ===== -->
        <main class="content">
            @yield('content')
        </main>

        <!-- ===== SIDEBAR KANAN ===== -->
        <aside class="sidebar-right">
            @yield('rightbar')
        </aside>

    </div>

    <!-- ===== NAVBAR MOBILE ===== -->
    <nav class="navbar navbar-light bg-white shadow-sm fixed-top d-md-none px-3 py-2">
        <div class="d-flex justify-content-between align-items-center w-100">

            <!-- Hamburger -->
            <button class="btn btn-link text-dark fs-4 p-0" id="mobileMenuToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Search bar -->
            <form class="d-flex align-items-center flex-grow-1 mx-2" action="{{ route('search') }}" method="GET">
                <span class="input-group-text border-0 bg-transparent pe-2">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input class="form-control border-0 shadow-none" type="search" name="q" placeholder="Cari di Pagee...">
            </form>

            <!-- Profile & Mode -->
            <div class="d-flex align-items-center">
                <button id="modeToggleMobile" class="btn btn-link text-dark fs-4 p-0 me-2" title="Ubah tema">
                    <i class="fa-solid fa-moon"></i>
                </button>
                @auth
                <a href="{{ route('profile.show') }}" class="btn btn-link text-dark fs-4 p-0" title="Profil">
                    <i class="fa-solid fa-user profile-icon"></i>
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ===== MOBILE SIDEBAR ===== -->
    <div id="mobileSidebar" class="mobile-sidebar d-md-none">
        <ul class="list-unstyled mt-4">
            <li><a href="{{ route('home') }}" class="sidebar-link @yield('nav-home')"><i class="fa-solid fa-house me-2"></i>Beranda</a></li>
            <li><a href="{{ route('whisper.index') }}" class="sidebar-link @yield('nav-whisper')"><i class="fa-regular fa-comment-dots me-2"></i>Whisper</a></li>
            <li><a href="{{ route('chapter') }}" class="sidebar-link @yield('nav-chapter') }}"><i class="fa-solid fa-book-open me-2"></i>Books</a></li>
            @auth
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button type="submit" class="btn btn-purple w-100 mt-2">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Logout
                        </button>
                    </form>
                </li>
            @endauth
            @guest
                <li>
                    <a href="{{ route('login') }}" class="btn btn-purple w-100 mt-2">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                    </a>
                </li>
            @endguest
        </ul>
    </div>

    <!-- Overlay -->
    <div class="mobile-sidebar-overlay d-md-none"></div>

    <!-- global login status -->
    <script>
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/script.js') }}"></script>

    <script>
        // Hamburger toggle
        const mobileSidebar = document.getElementById('mobileSidebar');
        const overlay = document.querySelector('.mobile-sidebar-overlay');

        document.getElementById('mobileMenuToggle').addEventListener('click', () => {
            mobileSidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.classList.toggle('darken');
        });

        overlay.addEventListener('click', () => {
            mobileSidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.classList.remove('darken');
        });
    </script>

    @stack('scripts')

</body>
</html>
