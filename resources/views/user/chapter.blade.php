@extends('user.layouts')

@section('title', 'Beranda')

{{-- === KONTEN UTAMA === --}}
@section('content')

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
</style>


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
        <a href="{{ route('chapter.show', $post->id_post) }}" class="post-title">
          {{ $post->judul }}
        </a>
      </div>

    </div>
  </div>
  @endforeach

</div>

@endsection


{{-- === SIDEBAR KANAN === --}}
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
