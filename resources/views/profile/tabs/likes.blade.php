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
</style>

<div id="likedPosts">
    @forelse($likes as $post)
        <div class="card liked-post shadow-sm mb-3" data-post-id="{{ $post->id_post }}">
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
                @endif
                <p class="mb-2">{{ $post->isi }}</p>

                {{-- LIKE ACTION --}}
                <div class="d-flex align-items-center gap-3 mt-2">
                    <button class="action-btn toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="{{ $post->likedBy(auth()->id()) ? 'fa-solid text-danger fa-heart' : 'fa-regular fa-heart' }}"></i>
                    </button>
                    <span class="like-count">{{ $post->likes->count() }} likes</span>
                </div>

            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada likes.</p>
    @endforelse
</div>

@push('scripts')
<script>
document.querySelectorAll('.toggle-love-btn').forEach(btn => {
    btn.addEventListener('click', function() {

        // SIMPAN SEBELUM FETCH
        let icon = this.querySelector('i');
        let card = this.closest('.card');
        let likeCountEl = this.closest('.card-body').querySelector('.like-count');

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

            // === UPDATE IKON ===
            if(data.status === 'liked'){
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid", "text-danger");
            } else {
                icon.classList.remove("fa-solid", "text-danger");
                icon.classList.add("fa-regular");

                // === HAPUS CARD ===
                if(document.getElementById('likedPosts') && card){
                    card.remove();
                }
            }

            // === UPDATE LIKE COUNT ===
            if(likeCountEl) likeCountEl.textContent = data.count + " likes";
        })
        .catch(console.error);
    });
});
</script>
@endpush
