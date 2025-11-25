<style>
.posts-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 kolom fix */
    gap: 14px;
}

.post-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    transition: 0.2s;
}

/* cover lebih pendek */
.post-cover {
    width: 100%;
    height: 140px;
    object-fit: cover;
}
.post-body {
    padding: 10px 14px;
}

.post-title {
    font-size: 14px;
    -webkit-line-clamp: 2;
    height: 38px;
}

.post-text {
    font-size: 12.5px;
    color: #666;
}

</style>

<div class="posts-grid mt-3">

@forelse($posts->where('jenis_post', '==', 'long') as $post)
    <div class="post-card">
        
        {{-- HEADER USER --}}
        <div class="post-header d-flex align-items-center p-3">
            <img 
                src="{{ $post->user->foto ? asset('storage/'.$post->user->foto) : 'https://via.placeholder.com/40' }}"
                class="rounded-circle me-2"
                width="40" height="40"
            >
            <div class="post-user-info">
                <span class="user-name fw-semibold d-block">{{ $post->user->nama }}</span>
                <span class="post-date text-muted small">
                    {{ $post->tanggal_dibuat 
                        ? \Carbon\Carbon::parse($post->tanggal_dibuat)->format('d M Y H:i') 
                        : $post->created_at->format('d M Y H:i') 
                    }}
                </span>
            </div>
        </div>

        {{-- COVER --}}
        @if($post->cover)
            <img src="{{ asset('storage/'.$post->cover->cover_path) }}" class="post-cover">
        @endif

        {{-- BODY --}}
        <div class="post-body">

            {{-- JUDUL --}}
            <h5 class="post-title">{{ $post->judul }}</h5>

            {{-- ISI / TEKS --}}
            <p class="post-text text-muted">
                {{ \Illuminate\Support\Str::limit($post->isi, 120) }}
            </p>

        </div>

        {{-- FOOTER --}}
        <div class="post-footer px-3 pb-3 d-flex justify-content-between text-muted small">
            <span>{{ ucfirst($post->jenis_post ?? 'Umum') }}</span>
            <span>ID: {{ $post->id_post }}</span>
        </div>

    </div>
@empty
    <p class="text-muted mt-3">Belum ada chapter.</p>
@endforelse

</div>
