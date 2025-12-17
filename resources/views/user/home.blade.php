@extends('user.layouts')

@section('title', 'Beranda')
@section('nav-home', 'active')

@section('content')

@if(session('justLoggedIn'))
    <div id="welcome-screen">
        <div class="ocean-bg"></div>

        <div class="welcome-center">
            <img src="{{ asset('assets/image/whale2.png') }}" class="floating-whale" alt="Whale">

            <h1 class="welcome-text">
                Welcome, {{ Auth::user()->nama }} ✨
            </h1>

            <p class="welcome-subtext">
                Every idea you have is a wave waiting to dance 🌊
            </p>
        </div>
    </div>
@endif

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<style>
/* =========================================================
   PAGEE - GLOBAL STYLE
========================================================= */

/* ===== BODY & TYPOGRAPHY ===== */
body {
    background-color: #f9f9f9;
    color: #1f2937;
    transition: background-color 0.3s, color 0.3s;
}

/* ===== DARK MODE ===== */
body.dark-mode {
    background-color: #0f1115;
    color: #e5e7eb;
}

/* ===== NAVBAR ===== */
.navbar {
    transition: background-color 0.3s, color 0.3s;
}
body.dark-mode .navbar {
    background-color: #181b21 !important;
    color: #e5e7eb !important;
}

/* ===== SIDEBAR ===== */
.sidebar-left, .sidebar-right {
    background-color: #fff;
    color: #1f2937;
    transition: background-color 0.3s, color 0.3s;
}
body.dark-mode .sidebar-left, body.dark-mode .sidebar-right {
    background-color: #181b21;
    color: #e5e7eb;
}

/* Sidebar links */
.sidebar-link {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.3s;
}
.sidebar-link i {
    transition: color 0.3s;
}
body.dark-mode .sidebar-link {
    color: #d1d5db;
}
.sidebar-link.active {
    color: #7c3aed !important;
}
body.dark-mode .sidebar-link.active {
    color: #a78bfa !important;
}
.sidebar-link:hover { color: #7c3aed; }
body.dark-mode .sidebar-link:hover { color: #c4b5fd; }

/* ===== BUTTONS ===== */
.btn-purple {
    background-color: #7c3aed;
    border-color: #7c3aed;
    color: #fff;
    transition: background-color 0.3s, border-color 0.3s;
}
.btn-purple:hover {
    background-color: #9d4edd;
    border-color: #9d4edd;
}
body.dark-mode .btn-purple {
    background-color: #7c3aed;
    border-color: #7c3aed;
    color: #fff;
}

/* ===== POST CARD ===== */
.card {
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background-color: #fff;
    color: #1f2937;
}
body.dark-mode .card {
    background-color: #181b21;
    color: #e5e7eb;
    border-color: #2a2e37;
}

/* Card text muted */
.card .text-muted {
    color: #6b7280 !important;
}
body.dark-mode .card .text-muted {
    color: #9ca3af !important;
}

/* Action buttons */
.action-btn, .toggle-love-btn {
    color: #6b7280;
    transition: color 0.3s;
}
.action-btn:hover, .toggle-love-btn:hover {
    color: #7c3aed;
}
body.dark-mode .action-btn, body.dark-mode .toggle-love-btn {
    color: #9ca3af;
}

/* Heart liked */
.fa-heart.text-danger {
    color: #ef4444;
}

/* Comments */
.comment-input {
    background-color: #f3f4f6;
    color: #1f2937;
    border: 1px solid #d1d5db;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}
.comment-input::placeholder {
    color: #9ca3af;
}
body.dark-mode .comment-input {
    background-color: #111827;
    color: #e5e7eb;
    border-color: #374151;
}
body.dark-mode .comment-input::placeholder {
    color: #9ca3af;
}

/* ===== MODAL ===== */
.modal-content {
    transition: background-color 0.3s, color 0.3s;
    background-color: #fff;
}
body.dark-mode .modal-content {
    background-color: #181b21;
    color: #e5e7eb;
}
/* Close button */
body.dark-mode .btn-close {
    filter: invert(1);
}

/* ===== FLOATING BUTTON ===== */
.floating-btn {
    background-color: #7c3aed;
    color: #fff;
    z-index: 9990;
    transition: background-color 0.3s, transform 0.2s;
}
.floating-btn:hover {
    transform: scale(1.1);
}
body.dark-mode .floating-btn {
    background-color: #9d4edd;
    color: #fff;
}

/* ===== WELCOME SCREEN FULL ===== */
#welcome-screen {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: radial-gradient(circle at top, #0b1220, #000);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.ocean-bg {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at bottom, rgba(124,58,237,0.15), transparent 60%);
}

.welcome-center {
    position: relative;
    text-align: center;
    color: white;
    z-index: 2;
    font-family: 'Montserrat', sans-serif;
}

.floating-whale {
    width: 420px;
    max-width: 80vw;
    animation: floatWhale 6s ease-in-out infinite;
    filter: drop-shadow(0 20px 40px rgba(124,58,237,0.4));
}

.welcome-text {
    font-family: 'Pacifico', cursive;
    font-size: 2.8rem;
    margin-top: 20px;
}

.welcome-subtext {
    font-size: 1.1rem;
    opacity: 0.85;
    margin-top: 10px;
}

@keyframes floatWhale {
    0% { transform: translateY(0); }
    50% { transform: translateY(-25px); }
    100% { transform: translateY(0); }
}


/* ===== WARNA USER LINK ===== */
.user-link {
    color: #1f2937;
    transition: color 0.3s;
}
body.dark-mode .user-link {
    color: #e5e7eb;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .sidebar-right {
        display: none;
    }
}
@media (max-width: 768px) {
    .sidebar-left {
        position: fixed;
        left: -100%;
        z-index: 1050;
        width: 220px;
        transition: left 0.3s;
    }
    .sidebar-left.active {
        left: 0;
    }
    .main-layout {
        flex-direction: column;
        margin-top: 60px;
    }

    /* Floating Button responsive */
    .floating-btn {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
        bottom: 15px;
        right: 15px;
    }
}
@media (max-width: 480px) {
    .floating-btn {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        bottom: 12px;
        right: 12px;
    }
}
.avatar-wrapper {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0; /* penting kalau di flex */
}

.avatar-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

</style>
@endpush
{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')
<!-- Floating Button -->
<button class="floating-btn" id="postTypeTrigger">
    <i class="fa-solid fa-plus"></i>
</button>

<!-- Modal Pilih Post -->
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
                    Add Book
                </button>
            </div>

        </div>
    </div>
</div>

<!-- POST FEED -->
<div id="feedPosts">
    @forelse($posts as $post)
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-2">
                    @if(!$post->is_anonymous)
                        <a href="{{ route('user.profile', $post->user->id_user) }}"
                            class="d-flex align-items-center text-decoration-none user-link">
                            <div class="avatar-wrapper me-2">
                                <img src="{{ $post->user->foto ? asset('storage/' . $post->user->foto) : 'https://i.pravatar.cc/45' }}"
                                    class="rounded-circle me-2" width="45" style="object-fit: cover;">
                            </div>
                            <div>
                                <strong>{{ $post->user->nama }}</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @else
                        <div class="d-flex align-items-center">
                            <div class="avatar-wrapper me-2">
                                <img src="https://i.pravatar.cc/45?img=0" class="rounded-circle me-2" width="45" style="object-fit: cover;">
                            </div>
                            <div>
                                <strong>@Anonymous</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- LONG POST (NOVEL, CERITA, DLL) -->
                @if($post->jenis_post === 'long')
                    <h5 class="fw-bold mb-2">{{ $post->judul }}</h5>

                    @php
                        $chapter = $post->chapters->first();
                    @endphp

                    @if($chapter)
                        <a href="{{ route('chapter.read', [$post->id_post, $chapter->id_chapter]) }}"
                        class="text-purple fw-semibold text-decoration-none d-block"
                        style="font-size: 14px;">
                        📖 Baca Terbaru: <em>"{{ $chapter->judul_chapter }}"</em>
                        </a>

                        @php
                            $plainText = strip_tags($chapter->isi_chapter);
                            $short = Str::limit($plainText, 180, '...');
                        @endphp

                        <p class="mt-2 text-muted"
                        style="font-size: 14px; line-height: 1.4; max-height: 63px; overflow: hidden;">
                            {{ $short }}
                        </p>
                    @else
                        <small class="text-muted d-block mb-2">
                            Belum ada chapter yang dirilis.
                        </small>
                    @endif
                @else
                    <!-- SHORT POST (STATUS BIASA) -->
                    <p>{{ $post->isi }}</p>
                @endif

                <!-- ACTION BUTTONS -->
                <div class="d-flex gap-4 action-wrapper">
                    @if(!$post->is_anonymous)
                    <button class="action-btn" onclick="toggleComment(this)">
                        <i class="fa-regular fa-comment"></i>
                    </button>
                    @endif

                    <button class="action-btn toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="{{ $post->likedBy(auth()->id()) ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart"></i>
                    </button>

                    <span class="like-count">{{ $post->likes->count() }} likes</span>
                    @if(!$post->is_anonymous)
                    <button class="action-btn share-btn"
                            data-url="{{ route('posts.show', $post->id_post) }}"
                            data-title="Post by {{ $post->user->nama ?? 'Anonymous' }}">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                    @endif
                </div>

                <!-- COMMENT BOX -->
                <div class="comment-box mt-2 d-none d-flex gap-2">
                    <input type="text"
                           class="form-control comment-input"
                           data-post-id="{{ $post->id_post }}"
                           placeholder="Tulis komentar...">

                    <button class="btn btn-purple btn-sm send-comment-btn"
                            data-post-id="{{ $post->id_post }}">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>

                <div class="comments-list mt-2">
                    @forelse($post->comments as $comment)
                        <div class="d-flex mb-2">
                            <strong>{{ $comment->user->nama }}:</strong>
                            <span class="ms-1">{{ $comment->isi_komentar }}</span>
                        </div>
                    @empty
                        <small class="text-muted">Belum ada komentar.</small>
                    @endforelse
                </div>

            </div>
        </div>
    @empty
        <div class="text-center text-muted my-3">
            Belum ada postingan.
        </div>
    @endforelse
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
            <i class="fa-solid fa-comment-dots me-2"></i>Tren Whisper
        </h5>

        <ul class="list-unstyled small mt-2">
            @forelse($trends as $trend)
                <li>
                    <a href="{{ route('whisper.index') }}" class="text-decoration-none text-dark">
                        {{ $trend }}
                    </a>
                </li>
            @empty
                <li class="text-muted">Belum ada tren.</li>
            @endforelse
        </ul>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ==== WELCOME SCREEN ==== */
document.addEventListener("DOMContentLoaded", () => {
    const screen = document.getElementById("welcome-screen");
    if (!screen) return;

    setTimeout(() => {
        screen.style.transition = "opacity 0.6s ease";
        screen.style.opacity = "0";

        setTimeout(() => {
            screen.remove();
        }, 600);

    }, 3000); // ⏱️ CUMA 3 DETIK
});
</script>

<script>
/* ==== ACTIONS ==== */
document.querySelectorAll('.toggle-love-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let icon = this.querySelector('i');
        let postId = this.dataset.postId;

        fetch("{{ route('post.like') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id_post: postId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'liked'){
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid", "text-danger");
            } else {
                icon.classList.remove("fa-solid", "text-danger");
                icon.classList.add("fa-regular");
            }

            // update like count jika ada
            let likeCountEl = btn.closest('.card-body').querySelector('.like-count');
            if(likeCountEl) likeCountEl.textContent = data.count + " likes";
        })
        .catch(console.error);
    });
});

function toggleComment(btn) {
    let box = btn.closest('.action-wrapper').nextElementSibling;
    box.classList.toggle('d-none');
}

</script>

<script>
document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', async function () {

        const url = this.dataset.url;
        const title = this.dataset.title ?? 'Pagee';
        const text = 'Baca tulisan menarik di Pagee ✨';

        // ====== WEB SHARE API (HP / Browser modern) ======
        if (navigator.share) {
            try {
                await navigator.share({
                    title: title,
                    text: text,
                    url: url
                });
            } catch (err) {
                console.log('Share dibatalkan');
            }
            return;
        }

        // ====== FALLBACK: COPY LINK ======
        try {
            await navigator.clipboard.writeText(url);
            showShareToast("Link berhasil disalin 📋");
        } catch {
            showShareToast("Gagal menyalin link ❌");
        }
    });
});

// ====== TOAST ======
function showShareToast(message) {
    let toast = document.createElement('div');
    toast.className = "share-toast";
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 1800);
}
</script>

<script>
/* ==== POST TYPE MODAL ==== */
document.getElementById("postTypeTrigger").addEventListener("click", function () {
    if (!isLoggedIn) return window.location.href = "{{ route('login') }}";
    new bootstrap.Modal(document.getElementById("postTypeModal")).show();
});

document.getElementById("shortPostBtn").addEventListener("click", function () {
    window.location.href = this.dataset.url;
});

document.getElementById("longPostBtn").addEventListener("click", function () {
    window.location.href = this.dataset.url;
});
</script>

<script>
/* ==== COMMENT SUBMIT ==== */
document.addEventListener("DOMContentLoaded", function () {

    function sendComment(postId, inputEl) {

        // ==== Prevent comment if not logged in ====
        @guest
            alert("Silakan login untuk menulis komentar.");
            return;
        @endguest

        let comment = inputEl.value.trim();
        if (comment === "") return;

        fetch("{{ route('comment.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: new URLSearchParams({
                id_post: postId,
                isi_komentar: comment
            })
        })

        .then(r => r.json())
        .then(response => {
            inputEl.value = "";

            let list = inputEl.closest('.card-body').querySelector('.comments-list');

            let newComment = document.createElement('div');
            newComment.classList.add('d-flex', 'mb-2');
            newComment.innerHTML =
                `<strong>{{ Auth::user()->nama ?? 'Guest' }}:</strong>
                <span class="ms-1">${response.data.isi_komentar}</span>`;

            list.prepend(newComment);
        })

        .catch(console.error);
    }

    // ==== ENTER KEY SEND ====
    document.querySelectorAll('.comment-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendComment(this.dataset.postId, this);
            }
        });
    });

    // ==== BUTTON SEND ====
    document.querySelectorAll('.send-comment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let postId = this.dataset.postId;
            let input = this.closest('.comment-box').querySelector('.comment-input');
            sendComment(postId, input);
        });
    });

    // ==== Disable comment input if guest ====
    @guest
        document.querySelectorAll('.comment-input').forEach(inp => inp.disabled = true);
    @endguest

});
</script>

@endpush
