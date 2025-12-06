<div id="likedPosts">
    @forelse($likes as $post)
        <div class="card liked-post shadow-sm mb-3 animate-float" data-post-id="{{ $post->id_post }}">
            <div class="card-body">

                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $post->user->foto ? asset('storage/' . $post->user->foto) : 'https://i.pravatar.cc/45' }}"
                         class="rounded-circle me-2" width="45">
                    <div>
                        <strong>{{ $post->user->nama }}</strong><br>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- POST CONTENT -->
                @if($post->jenis_post === 'long')
                    <h5 class="fw-bold mb-2">{{ $post->judul }}</h5>
                @endif
                <p>{{ $post->isi }}</p>

                <!-- ACTIONS -->
                <div class="d-flex gap-3 align-items-center action-wrapper">
                    <button class="action-btn toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="fa-{{ auth()->user()->likes->contains('id_post', $post->id_post) ? 'solid text-danger' : 'regular' }} fa-heart"></i>
                    </button>
                    <span class="like-count">{{ $post->likes->count() }} likes</span>
                </div>

            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada likes.</p>
    @endforelse
</div>
