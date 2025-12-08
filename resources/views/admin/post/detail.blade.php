<div class="mb-3">
    <h5>{{ $post->judul }}</h5>
    <p><strong>Penulis:</strong> {{ $post->user->nama ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ $post->created_at->format('d M Y') }}</p>
</div>
<hr>
<div class="mb-3">
    {!! nl2br(e($post->isi)) !!}
</div>

<div class="d-flex justify-content-end gap-2 mt-3">
    <button class="btn btn-danger btn-sm" onclick="deletePostModal({{ $post->id_post }})">Hapus</button>
</div>
