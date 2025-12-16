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
    /* ==== WELCOME SCREEN ==== */
    .welcome-screen {
        position: fixed;
        top:0; left:0;
        width:100vw; height:100vh;
        background: #000;
        display:flex; justify-content:center; align-items:center;
        flex-direction: column;
        z-index: 9999;
        overflow: hidden;
        animation: fadeIn 0.6s ease forwards;
    }

    .star {
        position: absolute;
        width: 2px; height: 2px;
        background: white;
        border-radius: 50%;
        opacity: 0.8;
        animation: twinkle 10s infinite alternate;
    }

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

    .welcome-subtext {
        font-size: 1.2rem;
        margin-top: -5px;
    }

    .whale {
        width: 200px;
        animation: swim 15s ease-in-out infinite alternate;
        margin-bottom: 2rem;
    }

    @keyframes floatText {
        0%,100% { transform: translateY(0px);}
        50% { transform: translateY(-15px);}
    }

    @keyframes swim {
        0% { transform: translateY(0) rotate(0deg);}
        50% { transform: translateY(-30px) rotate(-3deg);}
        100% { transform: translateY(0) rotate(0deg);}
    }

    @keyframes fadeIn {
        0% { opacity:0; }
        100% { opacity:1; }
    }

    /* ==== ACTION BUTTONS ==== */
    .send-comment-btn {
        padding: 6px 10px;
        font-size: 14px;
    }

    .action-btn {
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: #6c6c6c;
    }

    .action-btn.active i {
        color: red;
    }

    .comment-box {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity:0; transform:scale(0.95); }
        to   { opacity:1; transform:scale(1); }
    }

    /* SHARE TOAST */
    .share-toast {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        background: #333;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        opacity: 0;
        transition: 0.3s ease;
    }

    .share-toast.show {
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }

    .toggle-love-btn {
    border: none;
    background: none;
    cursor: pointer;
    color: #6c6c6c; /* default abu */
    font-size: 1rem;
    transition: color 0.2s;
}

.toggle-love-btn:focus {
    outline: none; /* hilangkan outline biru saat klik */
    box-shadow: none;
}

.toggle-love-btn .fa-solid.text-danger {
    color: red; /* hanya merah saat liked */
}

.comment-input:disabled {
    background: #f0f0f0;
    cursor: not-allowed;
}


</style>
@endpush
{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')

<!-- POST FEED -->
<div id="feedPosts">
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-2">
                    @if(!$post->is_anonymous)
                        <a href="{{ route('user.profile', $post->user->id_user) }}"
                           class="d-flex align-items-center text-decoration-none text-dark">
                            <img src="{{ $post->user->foto ? asset('storage/' . $post->user->foto) : 'https://i.pravatar.cc/45' }}"
                                 class="rounded-circle me-2" width="45">

                            <div>
                                <strong>{{ $post->user->nama }}</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @else
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/45?img=0" class="rounded-circle me-2" width="45">
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

                    <button class="action-btn" onclick="toggleComment(this)">
                        <i class="fa-regular fa-comment"></i>
                    </button>

                    <button class="action-btn toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="{{ $post->likedBy(auth()->id()) ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart"></i>
                    </button>

                    <span class="like-count">{{ $post->likes->count() }} likes</span>

                    <button class="action-btn share-btn"
                            data-url="{{ route('posts.show', $post->id_post) }}"
                            data-title="Post by {{ $post->user->nama ?? 'Anonymous' }}">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
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
    const welcomeScreen = document.getElementById('welcome-screen');

    if (welcomeScreen) {
        for (let i = 0; i < 100; i++) {
            let star = document.createElement('div');
            star.classList.add('star');
            star.style.top = Math.random() * window.innerHeight + 'px';
            star.style.left = Math.random() * window.innerWidth + 'px';
            star.style.width = star.style.height = Math.random()*2 + 1 + 'px';
            star.style.animationDuration = (Math.random()*3 + 2) + 's';
            welcomeScreen.appendChild(star);
        }

        const textEl = welcomeScreen.querySelector('.welcome-text');
        const fullText = textEl.textContent;
        textEl.textContent = '';
        textEl.style.borderRight = '3px solid white';

        let i = 0;
        function type() {
            if (i < fullText.length) {
                textEl.textContent += fullText.charAt(i);
                i++;
                setTimeout(type, 50);
            } else {
                textEl.style.borderRight = 'none';
            }
        }
        type();

        setTimeout(() => {
            welcomeScreen.style.transition = "opacity 0.5s ease";
            welcomeScreen.style.opacity = 0;
            setTimeout(() => welcomeScreen.remove(), 500);
        }, 10000);
    }
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
