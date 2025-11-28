@extends('user.layouts')

@section('title', 'Beranda')
@section('nav-home', 'active')

@section('content')

@if(session('justLoggedIn'))
<div id="welcome-screen" class="welcome-screen">
    <div class="welcome-content">
        <img src="{{ asset('assets/image/whale2.png') }}" alt="Whale" class="whale">
        <h1 class="welcome-text" id="welcomeText">
            {{ "Welcome, " . Auth::user()->nama . ", wanderer of dreams ✨" }}
        </h1>
        <p class="welcome-subtext">Every idea you have is a wave waiting to dance 🌊</p>
    </div>
</div>
@endif


@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<style>
/* Fullscreen welcome screen polos */
.welcome-screen {
    position: fixed;
    top:0; left:0;
    width:100vw; height:100vh;
    background: #000; /* background hitam polos */
    display:flex; justify-content:center; align-items:center;
    flex-direction: column;
    z-index: 9999;
    overflow: hidden;
    animation: fadeIn 0.6s ease forwards;
}

/* Stars background */
.star {
    position: absolute;
    width: 2px; height: 2px;
    background: white;
    border-radius: 50%;
    opacity: 0.8;
    animation: twinkle 10s infinite alternate;
}

/* Animasi bintang */
@keyframes twinkle {
    0% { opacity:0.2; }
    50% { opacity:1; }
    100% { opacity:0.2; }
}

.welcome-content {
    text-align: center;
    color: #fff;
    animation: floatText 10s ease-in-out infinite;
    z-index: 10;
    font-family: 'Montserrat', sans-serif; 
}

.welcome-text {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    overflow: hidden;
    white-space: nowrap;
    border-right: 3px solid white;
    font-family: 'Pacifico', cursive;
}

.highlight {
    color: #ffdd57;
}

.welcome-subtext {
    font-size: 1.2rem;
    margin-top: -5px;
}

/* Animasi paus */
.whale {
    width: 200px;
    animation: swim 15s ease-in-out infinite alternate;
    margin-bottom: 2rem;
    font-family: 'Montserrat', sans-serif;
}

/* Floating teks */
@keyframes floatText {
    0%,100% { transform: translateY(0px);}
    50% { transform: translateY(-15px);}
}

/* Paus naik-turun */
@keyframes swim {
    0% { transform: translateY(0) rotate(0deg);}
    50% { transform: translateY(-30px) rotate(-3deg);}
    100% { transform: translateY(0) rotate(0deg);}
}

/* Fade in */
@keyframes fadeIn {
    0% { opacity:0; }
    100% { opacity:1; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const welcomeScreen = document.getElementById('welcome-screen');
    if(welcomeScreen){
        // buat stars
        for(let i = 0; i < 100; i++){
            let star = document.createElement('div');
            star.classList.add('star');
            star.style.top = Math.random() * window.innerHeight + 'px';
            star.style.left = Math.random() * window.innerWidth + 'px';
            star.style.width = star.style.height = Math.random()*2 + 1 + 'px';
            star.style.animationDuration = (Math.random()*3 + 2) + 's';
            welcomeScreen.appendChild(star);
        }

        // typing effect
        const textEl = welcomeScreen.querySelector('.welcome-text');
        const fullText = textEl.textContent;
        textEl.textContent = '';
        textEl.style.borderRight = '3px solid white';
        let i = 0;
        function type() {
            if(i < fullText.length){
                textEl.textContent += fullText.charAt(i);
                i++;
                setTimeout(type, 50);
            } else {
                textEl.style.borderRight = 'none';
            }
        }
        type();

        // otomatis fade out
        setTimeout(() => {
            welcomeScreen.style.transition = "opacity 0.5s ease";
            welcomeScreen.style.opacity = 0;
            setTimeout(() => {
                welcomeScreen.remove();
            }, 500);
        }, 10000);
    }
});
</script>
@endpush

<!-- Floating Button (TETAP DI HALAMAN INI, BUKAN LAYOUT) -->
<button class="floating-btn" id="postTypeTrigger">
    <i class="fa-solid fa-plus"></i>
</button>

<!-- ===== Modal Pilih Jenis Post ===== -->
<div class="modal fade" id="postTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Jenis Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-3">Mau membuat post pendek atau panjang?</p>

                <button class="btn btn-purple w-100 mb-2"
                    id="shortPostBtn"
                    data-url="{{ route('post-short-create') }}">
                    Short Post
                </button>

                <button class="btn btn-purple w-100"
                    id="longPostBtn"
                    data-url="{{ route('post-long-create') }}">
                    Long Post
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ===== FEED POST ===== -->
<div id="feedPosts">

    @foreach($posts as $post)
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-2">

                    @if(!$post->is_anonymous)
                        <a href="{{ route('user.profile', $post->user->id_user) }}"
                           class="d-flex align-items-center text-decoration-none text-dark">
                            <img src="{{ $post->user->pp ?? 'https://i.pravatar.cc/45' }}"
                                 class="rounded-circle me-2" width="45">
                            <div>
                                <strong>{{ $post->user->nama }}</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @else
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/45?img=0"
                                 class="rounded-circle me-2" width="45">
                            <div>
                                <strong>@Anonymous</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- JUDUL KHUSUS LONG POST -->
                @if($post->jenis_post === 'long')
                    <h5 class="fw-bold mb-2">{{ $post->judul }}</h5>
                @endif

                <!-- ISI POST -->
                <p>{{ $post->isi }}</p>

                <!-- ACTIONS -->
                <div class="d-flex gap-4">
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-regular fa-comment"></i>
                    </button>
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>

            </div>
        </div>
    @endforeach

</div>

@endsection


@section('rightbar')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="fw-bold text-purple">
                <i class="fa-solid fa-music me-2"></i>Musik Populer
            </h5>
            <ul class="list-unstyled small mt-2">
                <li>Daylight - David Kushner</li>
                <li>Blue - Keshi</li>
                <li>Runaway - AURORA</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold text-purple">
                <i class="fa-solid fa-fire me-2"></i>Tren Whisper
            </h5>
            <ul class="list-unstyled small mt-2">
                @foreach($trends as $trend)
                    <li>{{ $trend }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    // === Floating Button Handler ===
    document.getElementById("postTypeTrigger").addEventListener("click", function () {
        if (!isLoggedIn) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        new bootstrap.Modal(document.getElementById("postTypeModal")).show();
    });

    // === Short Post Redirect ===
    document.getElementById("shortPostBtn").addEventListener("click", function () {
        window.location.href = this.dataset.url;
    });

    // === Long Post Redirect ===
    document.getElementById("longPostBtn").addEventListener("click", function () {
        window.location.href = this.dataset.url;
    });
</script>
@endpush
