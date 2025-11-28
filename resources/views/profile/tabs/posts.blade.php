<div class="posts-grid mt-3">
@forelse($posts->where('jenis_post', '!=', 'long') as $post)
    <div class="post-card">
        <div class="post-header">
            <img 
                src="{{ $post->user->foto ? asset('storage/'.$post->user->foto) : 'https://via.placeholder.com/40' }}" 
                alt="User Foto"
            >
            <div class="post-user-info">
                <span class="user-name">{{ $post->user->nama }}</span> <br>
                <span class="post-date">{{ $post->tanggal_dibuat ? \Carbon\Carbon::parse($post->tanggal_dibuat)->format('d M Y H:i') : $post->created_at->format('d M Y H:i') }}</span>
            </div>
        </div>
        <div class="post-body">
            <h5 class="post-title">{{ $post->judul }}</h5>
            <p class="post-text">{{ $post->isi }}</p>
        </div>
        <div class="post-footer">
            <span class="post-type">{{ $post->jenis_post ?? 'Umum' }}</span>
            <span class="post-id">ID: {{ $post->id_post }}</span>
        </div>
    </div>
@empty
    <p class="text-muted mt-3">Belum ada post.</p>
@endforelse
</div>
