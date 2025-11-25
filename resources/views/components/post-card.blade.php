<div class="card shadow-sm mb-3">
    <div class="card-body">

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
                <img src="https://i.pravatar.cc/45?img=0" class="rounded-circle me-2" width="45">
                <div>
                    <strong>@Anonymous</strong><br>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @endif

        </div>

        @if($post->jenis_post === 'long')
            <h5 class="fw-bold mb-2">{{ $post->judul }}</h5>
        @endif

        <p>{{ $post->isi }}</p>

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
