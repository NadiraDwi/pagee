@extends('user.layouts')

@section('title', 'Chapter')
@section('nav-chapter', 'active')

{{-- === KONTEN UTAMA === --}}
@section('content')

@php
  use Illuminate\Support\Str;
@endphp

<style>
/* ===== POST CARD ===== */
.post-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.2s ease;
    height: 330px;
    display: flex;
    flex-direction: column;
}

/* COVER */
.post-cover {
    width: 100%;
    height: 210px;
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

/* DESCRIPTION */
.post-desc {
    font-size: 0.9rem;
    color: #555;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ===== DARK MODE ===== */
body.dark-mode {
    background-color: #121212;
    color: #e5e7eb;
}

body.dark-mode .post-card {
    background-color: #1f1f1f;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

body.dark-mode .post-title {
    color: #f3f4f6;
}

body.dark-mode .post-title:hover {
    color: #bb86fc;
}

body.dark-mode .post-desc {
    color: #d1d5db;
}

body.dark-mode .floating-btn {
    background-color: #7b2cbf;
    color: #fff;
}

body.dark-mode .post-card a {
    color: inherit;
    text-decoration: none;
}

body.dark-mode hr,
body.dark-mode .sidebar-divider {
    border-color: #333;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .post-card {
        height: 310px;
    }
    .post-cover {
        height: 190px;
    }
}

@media (max-width: 992px) {
    .post-card {
        height: 300px;
    }
    .post-cover {
        height: 180px;
    }
    .post-title {
        font-size: 15px;
    }
    .post-desc {
        font-size: 0.85rem;
    }
}

@media (max-width: 768px) {
    .post-card {
        height: 280px;
    }
    .post-cover {
        height: 160px;
    }
    .post-title {
        font-size: 14px;
    }
    .post-desc {
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .post-card {
        height: auto;
    }
    .post-cover {
        height: 140px;
    }
    .post-title {
        font-size: 13px;
    }
    .post-desc {
        font-size: 0.75rem;
    }
    .post-body {
        padding: 8px;
    }
}

/* ===== FLOATING BUTTON ===== */
.floating-btn {
    background-color: #7c3aed;
    color: #fff;
    transition: background-color 0.3s, transform 0.2s;
}
.floating-btn:hover {
    transform: scale(1.1);
}
body.dark-mode .floating-btn {
    background-color: #9d4edd;
    color: #fff;
}

/* ===== RESPONSIVE FLOATING BUTTON ===== */
@media (max-width: 768px) {
    .floating-btn {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
        bottom: 15px;
        right: 15px;
    }
}

@media (max-width: 480px) {
    .floating-btn {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
        bottom: 12px;
        right: 12px;
    }
}

</style>
{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')
<!-- Floating Button -->
<a href="{{ route('post-long-create') }}">
<button class="floating-btn" id="postTypeTrigger">
    <i class="fa-solid fa-plus"></i>
</button>

</a>

<h5 class="fw-bold mb-3">Postingan Terbaru</h5>

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
      <a href="{{ route('chapter.show', $post->id_post) }}" class="post-title">
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
