<style>
/* === CARD EFFECT === */
.liked-post {
    border-radius: 12px;
    transition: 0.3s ease;
}
.liked-post:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 14px rgba(122, 57, 248, 0.15);
}

/* === ACTION BUTTON === */
.toggle-love-btn {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1.2rem;
    color: #6c6c6c;
    transition: 0.2s;
}
.toggle-love-btn:hover {
    transform: scale(1.15);
    color: #9b59ff;
}
.toggle-love-btn .fa-solid.text-danger {
    color: #e63946 !important;
}

/* === TEXT PURPLE === */
.text-purple {
    color: #7a39f8;
}

/* Batasi tinggi long post */
.long-post-text {
    max-height: 3em; /* kira-kira 2 baris (1.5em per baris) */
    overflow: hidden;
}

</style>

<div class="container">
    <div class="row g-3" id="likedPostsContainer">
        @forelse($likes as $post)
        <div class="col-md-4 liked-post-card" data-post-id="{{ $post->id_post }}">
            <div class="card liked-post shadow-sm">
                <div class="card-body">
                    {{-- USER INFO --}}
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $post->user->foto ? asset('storage/' . $post->user->foto) : 'https://i.pravatar.cc/45' }}"
                             class="rounded-circle me-2" width="45">
                        <div>
                            <strong>{{ $post->user->nama }}</strong><br>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    @if($post->jenis_post === 'long')
                        <h5 class="fw-bold text-purple mb-2">{{ $post->judul }}</h5>
                        <p class="mb-2 long-post-text">{{ $post->isi }}</p>
                    @else
                        <p class="mb-2">{{ $post->isi }}</p>
                    @endif

                    {{-- LIKE BUTTON --}}
                    <div class="d-flex gap-3 align-items-center">
                        <button class="toggle-love-btn" data-post-id="{{ $post->id_post }}">
                            <i class="fa-solid text-danger fa-heart"></i>
                        </button>
                        <span class="like-count">{{ $post->likes->count() }} likes</span>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Belum ada likes.</p>
        @endforelse
    </div>
</div>