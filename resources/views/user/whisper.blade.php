@extends('user.layouts')

@section('title', 'Whisper')
@section('nav-whisper', 'active')

@section('content')
<h3 class="mb-3">Whisper 🕊️</h3>

{{-- STYLE --}}
<style>
    .toggle-love-btn, .action-btn {
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: #6c6c6c; /* default abu */
        transition: 0.2s;
    }
    .toggle-love-btn:hover {
        transform: scale(1.15);
        color: #9b59ff;
    }
    .toggle-love-btn .fa-solid.text-danger {
        color: #e63946 !important; /* merah saat liked */
    }
    .text-purple {
        color: #7a39f8;
    }
</style>

{{-- RIGHT SIDEBAR --}}
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

{{-- FEED --}}
<div id="feedPosts">
    @foreach($whispers as $post)
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                {{-- USER INFO --}}
                <div class="d-flex align-items-center mb-2">
                    <img src="https://i.pravatar.cc/45?img=0" class="rounded-circle me-2" width="45">
                    <div>
                        <strong>@Anonymous</strong><br>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                {{-- CONTENT --}}
                <p>{{ $post->isi }}</p>

                {{-- LOVE ACTION ONLY --}}
                <div class="d-flex align-items-center gap-3 mt-2">
                    <button class="toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="{{ $post->likedBy(auth()->id()) ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart"></i>
                    </button>
                    <span class="like-count fw-bold text-purple">
                        {{ $post->likes->count() }} likes
                    </span>
                </div>

            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
/* LIKE ACTION */
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

            let likeCountEl = btn.closest('.card-body').querySelector('.like-count');
            if(likeCountEl) likeCountEl.textContent = data.count + " likes";
        })
        .catch(console.error);
    });
});
</script>
@endpush
