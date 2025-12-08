@extends('admin.layouts')

@section('title', 'Manajemen Postingan')

@section('content')

@php
  use Illuminate\Support\Str;
@endphp

<style>
.post-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.2s ease;
    height: 330px; /* dinaikkan agar muat cover baru */
    display: flex;
    flex-direction: column;
}

/* COVER — DIPANJANGKAN */
.post-cover {
    width: 100%;
    height: 210px; /* dari 170px → 210px */
    object-fit: cover;
}

/* BODY */
.post-body {
    padding: 12px;
    flex: 1;
}

/* TITLE MAX 2 LINES */
.post-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.3;
    height: 42px;
    color: #333;
    text-decoration: none;
}

.post-title:hover {
    color: #6f42c1;
}

.post-desc {
  font-size: 0.9rem;
  color: #555;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

</style>


<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Chapter</li>
                    <li class="breadcrumb-item">Manajemen Chapter</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">Manajemen Chapter</h2>
</div>

    <div class="row g-3">

    @foreach($posts as $post)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="post-card">

        {{-- COVER --}}
        @if($post->cover)
            <a href="{{ route('chapter.show', $post->id_post) }}">
            <img src="{{ asset('storage/' . $post->cover->cover_path) }}" class="post-cover">
            </a>
        @else
            <a href="{{ route('chapter.show', $post->id_post) }}">
            <img src="{{ asset('assets/image/logo.png') }}" class="post-cover">
            </a>
        @endif

        {{-- TITLE --}}
        <div class="post-body">
        {{-- TITLE --}}
        <a href="{{ route('admin.post.chapter.show', $post->id_post) }}" class="post-title">
            {{ $post->judul }}
        </a>

        {{-- SHORT DESCRIPTION (Limit 120 chars) --}}
        <p class="post-desc">
            {{ Str::limit(strip_tags($post->isi), 120, '...') }}
        </p>
        </div>

        </div>
    </div>
    @endforeach

    </div>

@endsection
