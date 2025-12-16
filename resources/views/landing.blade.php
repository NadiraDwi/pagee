<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pagee — Media Literasi Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <style>
:root {
    --primary: #6f42c1;
    --primary-soft: #f2ecfb;
}

/* ================= GLOBAL ================= */
body {
    font-family: 'Inter', sans-serif;
    background-color: #f6f7fb;
    color: #1f2937;
    position: relative; /* WAJIB untuk ScrollSpy */
}

html {
    scroll-behavior: smooth;
}

section {
    scroll-margin-top: 140px; /* Fix offset navbar */
}

/* ================= NAVBAR ================= */
.navbar-custom {
    background-color: #ffffff;
    padding: 16px 0;
    box-shadow: 0 6px 30px rgba(0,0,0,.06);
    transition: all .3s ease;
}

.navbar-custom .navbar-brand h3 {
    color: var(--primary);
}

.navbar-custom .nav-link {
    color: #374151;
    font-weight: 500;
    margin-left: 24px;
    position: relative;
    transition: color .2s ease;
}

.navbar-custom .nav-link:hover {
    color: var(--primary);
}

/* ACTIVE NAV */
.navbar-custom .nav-link.active {
    color: var(--primary);
    font-weight: 600;
}

.navbar-custom .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--primary);
    border-radius: 999px;
}

/* Toggler */
.navbar-toggler {
    border: none;
}

.navbar-toggler i {
    color: var(--primary);
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* ================= HERO ================= */
.hero {
    min-height: 100vh;
    background: #ffffff;
    display: flex;
    align-items: center;
}

.hero-badge {
    background: var(--primary-soft);
    color: var(--primary);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 16px;
}

/* ================= BUTTON ================= */
.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: #5a34a3;
    border-color: #5a34a3;
}

.btn-outline-primary {
    color: var(--primary);
    border-color: var(--primary);
}

.btn-outline-primary:hover {
    background-color: var(--primary);
    color: #fff;
}

/* ================= CARD ================= */
.card-soft {
    border: none;
    border-radius: 24px;
    box-shadow: 0 20px 50px rgba(0,0,0,.08);
    background: white;
}

/* ================= SECTION ================= */
.section {
    padding: 40px 0;
}

/* ================= FEATURE ================= */
.feature-card {
    background: white;
    border-radius: 20px;
    padding: 32px;
    height: 100%;
    box-shadow: 0 12px 40px rgba(0,0,0,.06);
}

.feature-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-soft);
    color: var(--primary);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 16px;
}

/* ================= LIST ICON ================= */
.list-icon i {
    color: var(--primary);
}

/* ================= CTA ================= */
.cta {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    border-radius: 32px;
    color: white;
}

/* ================= FOOTER ================= */
footer {
    background: #1f1235;
    color: #c4b5fd;
}

/* ================= FLOAT ANIMATION ================= */
.float-card {
    opacity: 0;
    transform: translateY(40px);
    transition: all .8s ease;
}

.float-card.show {
    opacity: 1;
    transform: translateY(0);
}

.float-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 30px 60px rgba(0,0,0,.12);
}

/* ================= TABLET ================= */
@media (max-width: 992px) {

    .hero {
        min-height: auto;
        padding-top: 120px;
        padding-bottom: 80px;
    }

    .hero h1 {
        font-size: 2.5rem;
    }

    .section {
        padding: 80px 0;
    }
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    body {
        text-align: center;
    }

    .navbar-custom {
        padding: 12px 0;
    }

    .navbar-collapse {
        background: #ffffff;
        margin-top: 12px;
        padding: 16px;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,.08);
    }

    .navbar-custom .nav-link {
        margin-left: 0;
        padding: 12px 0;
    }

    .hero {
        padding-top: 110px;
    }

    .hero h1 {
        font-size: 2.1rem;
    }

    .hero p {
        font-size: 1rem;
    }

    .hero-badge {
        margin-left: auto;
        margin-right: auto;
    }

    .hero .btn {
        width: 100%;
        margin-bottom: 12px;
    }

    .card-soft {
        padding: 14px !important;
        border-radius: 18px;
    }

    .hero .card-soft img,
    #feature .card-soft img {
        max-height: 260px;
        object-fit: cover;
        border-radius: 14px;
    }

    .feature-card {
        padding: 20px;
        border-radius: 18px;
    }

    .feature-icon {
        margin-left: auto;
        margin-right: auto;
    }

    .section {
        padding: 60px 0;
    }

    .cta {
        padding: 40px 24px;
    }

    .float-card {
        transform: translateY(20px);
    }

    .float-card:hover {
        transform: translateY(0);
        box-shadow: 0 16px 40px rgba(0,0,0,.08);
    }

    .row.g-5 {
        --bs-gutter-y: 2rem;
    }

    .row.g-4 {
        --bs-gutter-y: 1.5rem;
    }
}
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarPagee" data-bs-offset="120" tabindex="0">

<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">

        {{-- LOGO KIRI --}}
        <a class="navbar-brand" href="#hero">
            <h3 class="brand fw-bold text-purple fs-4 mb-4">Pagee<span class="dot">.</span></h3>
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler text-white" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarPagee">
            <i class="fa-solid fa-bars"></i>
        </button>

        {{-- MENU KANAN --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarPagee">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#hero">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#value">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#feature">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Mulai</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- ================= HERO ================= --}}
<section class="hero" id="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">
                    Platform Literasi Digital
                </span>

                <h1 class="fw-bold display-5 mb-3">
                    Tempat Cerita Tumbuh <br>
                    Tanpa Tekanan
                </h1>

                <p class="fs-5 text-muted mb-4">
                    Pagee adalah platform menulis dan membaca yang berfokus
                    pada emosi, kebebasan berekspresi, dan kenyamanan pengguna.
                </p>

                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                    Mulai Menulis
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                    Masuk
                </a>
            </div>

            <div class="col-lg-6">
                <div class="card-soft p-4 float-card">
                    <img src="{{ asset('assets/image/Pagee-prev.png') }}"
                         class="img-fluid rounded-4"
                         alt="Preview Pagee">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= VALUE ================= --}}
<section class="section bg-white" id="value">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Dirancang untuk Penulis & Pembaca</h2>
        <p class="text-muted mb-5">
            Pagee hadir sebagai ruang literasi yang aman dan berorientasi pada pengalaman.
        </p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card float-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <h5 class="fw-bold">Integrasi Musik</h5>
                    <p class="text-muted">
                        Musik mendukung suasana emosional dalam setiap tulisan.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card float-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-user-secret"></i>
                    </div>
                    <h5 class="fw-bold">Mode Anonim</h5>
                    <p class="text-muted">
                        Menulis tanpa identitas untuk kebebasan berekspresi.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card float-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h5 class="fw-bold">Tanpa Batas Karakter</h5>
                    <p class="text-muted">
                        Cocok untuk cerita pendek maupun panjang.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= DETAIL ================= --}}
<section class="section" id="feature">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="card-soft p-3 float-card">
                    <img src="{{ asset('assets/image/feed2.png') }}"
                         class="img-fluid rounded-4"
                         alt="Feed Pagee">
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">
                    Pengalaman Literasi yang Lebih Dalam
                </h2>

                <ul class="list-unstyled fs-5 list-icon">
                    <li class="mb-3">
                        <i class="fa-solid fa-check me-2"></i>
                        Chapter Mode untuk cerita berseri
                    </li>
                    <li class="mb-3">
                        <i class="fa-solid fa-check me-2"></i>
                        Time Capsule untuk pesan masa depan
                    </li>
                    <li class="mb-3">
                        <i class="fa-solid fa-check me-2"></i>
                        Dark & Light Mode
                    </li>
                    <li class="mb-3">
                        <i class="fa-solid fa-check me-2"></i>
                        Interaksi tanpa kompetisi
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================= FOOTER ================= --}}
<footer class="py-2">
    <div class="container text-center">
        <p class="mb-1 fw-bold text-white">Pagee</p>
        <small>© 2025 Pagee — Media Literasi Digital</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.navbar-custom .nav-link').forEach(link => {
        link.addEventListener('click', function () {
            document.querySelectorAll('.navbar-custom .nav-link')
                .forEach(nav => nav.classList.remove('active'));

            this.classList.add('active');
        });
    });
</script>

<script>
    const floatCards = document.querySelectorAll('.float-card');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, {
        threshold: 0.2
    });

    floatCards.forEach(card => observer.observe(card));
</script>

</body>
</html>
