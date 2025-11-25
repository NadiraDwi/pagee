@extends('user.layouts')

@section('title', 'Chapter')

@section('content')
<style>
.chapter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-radius: 10px;
    border: 1px solid #eee;
    background: #fff;
    transition: 0.2s ease;
    text-decoration: none; /* penting untuk hilangkan underline */
    color: inherit; /* supaya teks tetap hitam */
}

.chapter-row:hover {
    background: #f6f1ff;
    border-color: #d9c9ff;
    cursor: pointer;
}

.chapter-number {
    font-weight: 600;
    color: #6f42c1;
}

.chapter-title {
    flex: 1;
    margin-left: 12px;
    font-weight: 500;
    color: #000; /* judul jadi hitam */
    text-decoration: none;
}

.btn-outline-purple {
    border: 1.8px solid #6f42c1;
    color: #6f42c1;
    padding: 5px 14px;
    font-size: 14px;
    border-radius: 8px;
    background: transparent;
    transition: 0.2s ease;
    display: inline-block;
    text-decoration: none !important;
}

.btn-outline-purple:hover {
    background: #6f42c1;
    color: #fff;
}
</style>

<h4 class="fw-bold mb-3">{{ $post->judul }}</h4>

{{-- Button Tambah Chapter (Hanya Jika Login) --}}
@auth
<a href="{{ route('chapter.create', $post->id_post) }}" class="btn-outline-purple mb-4">
    + Tambah Chapter
</a>
@endauth

{{-- List Chapter Row --}}
<div class="d-flex flex-column gap-2">

    @forelse ($chapters as $i => $chapter)
        <a href="{{ route('chapter.show', $chapter->id_chapter) }}" class="chapter-row">

            <div class="chapter-number">Chapter {{ $i + 1 }}</div>

            <div class="chapter-title">
                {{ $chapter->judul_chapter }}
            </div>

        </a>
    @empty
        <p class="text-muted">Belum ada chapter.</p>
    @endforelse

</div>

@endsection
