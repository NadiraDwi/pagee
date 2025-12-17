@php
    $tab = request('tab') ?? 'posts';
    $allowedTabs = ['posts', 'chapter', 'whisper', 'timecapsule', 'likes'];
    if (!in_array($tab, $allowedTabs)) $tab = 'posts';
@endphp

@section('title', 'Beranda')
@section('nav-home', 'active')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public Profile - {{ $user->nama }}</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">


  <!-- CSS Global -->
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/profile.css') }}">

  <style>
    .avatar-wrapper {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0; /* penting kalau di flex */
}

.avatar-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

  </style>
</head>
<body>

<div class="profile-header"
     style="background-image: url('{{ $user->header ? asset('storage/'.$user->header) : asset('assets/default-header.jpg') }}');">
</div>

<div class="container mt-3">

  <div class="d-flex justify-content-between align-items-start">
      <img src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://i.pravatar.cc/45' }}"
           class="profile-picture" alt="Profile Picture">
  </div>

  <div class="mt-3 profile-page-text">
    <h4 class="fw-bold">{{ $user->nama }}</h4>
    <p class="username">{{ sprintf('@%s', $user->username) }}</p>

    @if($user->bio)
        <p class="mt-2">{{ $user->bio }}</p>
    @else
        <p class="mt-2 text-muted"><i>Belum ada bio</i></p>
    @endif

    <p class="text-muted mt-2">
        <i class="fa-regular fa-calendar"></i> Joined {{ $user->created_at->format('F Y') }}
    </p>

    <!-- ===== PROFILE TABS ===== -->
    <ul class="nav nav-tabs border-0 justify-content-center mb-3">
      <li class="nav-item mx-2">
          <a class="nav-link {{ $tab === 'posts' ? 'active' : '' }}" href="?tab=posts">Posts</a>
      </li>
      <li class="nav-item mx-2">
          <a class="nav-link {{ $tab === 'chapter' ? 'active' : '' }}" href="?tab=chapter">Chapter</a>
      </li>
    </ul>

    <!-- ===== TAB CONTENT ===== -->
@if($tab === 'posts')
    @php
        // Hanya post short & is_anonymous = 0
        $shortPosts = $posts->where('jenis_post', 'short')
                            ->where('is_anonymous', 0);
    @endphp

    @forelse($shortPosts as $post)
        <div class="post-card mb-3 p-3 rounded shadow-sm">
            <h5 class="fw-bold">{{ $post->judul }}</h5>
            <p class="text-muted">{{ \Illuminate\Support\Str::limit($post->isi, 150) }}</p>
        </div>
    @empty
        <p class="text-muted mt-3">Belum ada post.</p>
    @endforelse

@elseif($tab === 'chapter')
    @php
        // Filter post long
        $chapters = $posts->where('jenis_post', 'long');
    @endphp

    @forelse($chapters as $post)
        @php
            // Ambil cover dari tabel post_covers (ambil yang pertama kalau ada)
            $cover = \App\Models\PostCover::where('id_post', $post->id_post)->first();
        @endphp

        <a href="{{ route('chapter.show', $post->id_post) }}" class="text-decoration-none text-dark">
            <div class="post-card mb-3 p-3 rounded shadow-sm">

                {{-- COVER --}}
                @if($cover)
                    <img 
                        src="{{ asset('storage/' . $cover->cover_path) }}"
                        class="w-100 mb-3 rounded"
                        style="max-height: 250px; object-fit: cover;"
                    >
                @endif

                {{-- JUDUL --}}
                <h5 class="fw-bold" style="color: #6a4c93 !important;">{{ $post->judul }}</h5>

                {{-- ISI PREVIEW --}}
                <p class="text-muted">{{ \Illuminate\Support\Str::limit($post->isi, 150) }}</p>

                {{-- AUDIO --}}
                @if($post->link_musik)
                    <audio controls class="w-100 mt-2">
                        <source src="{{ $post->link_musik }}" type="audio/mpeg">
                    </audio>
                @endif

            </div>
        </a>
    @empty
        <p class="text-muted mt-3">Belum ada chapter.</p>
    @endforelse

@endif


  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
