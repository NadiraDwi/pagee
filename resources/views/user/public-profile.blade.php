@php
    $tab = request('tab') ?? 'posts';
    $allowedTabs = ['posts', 'chapter', 'whisper', 'timecapsule', 'likes'];
    if (!in_array($tab, $allowedTabs)) $tab = 'posts';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public Profile - {{ $user->nama }}</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Global -->
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/profile.css') }}">
</head>
<body>

<!-- ===== HEADER ===== -->
<div class="profile-header"></div>

<div class="container mt-3">

  <div class="d-flex justify-content-between align-items-start">

    <!-- FOTO PROFIL -->
    <img 
      src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://via.placeholder.com/120' }}"
      class="profile-picture"
      alt="Profile Picture"
    >

    <!-- Public profile = tidak ada tombol edit -->
  </div>

  <div class="mt-3 profile-page-text">
    <h4 class="fw-bold">{{ $user->nama }}</h4>
    <p class="username">@{{ $user->username }}</p>

    @if($user->bio)
      <p class="mt-2">{{ $user->bio }}</p>
    @else
      <p class="mt-2 text-muted"><i>Belum ada bio</i></p>
    @endif

    <p class="text-muted mt-2">
      <i class="fa-regular fa-calendar"></i>
      Joined {{ $user->created_at->format('F Y') }}
    </p>

    <!-- ===== PROFILE TABS ===== -->
    <ul class="nav nav-tabs border-0 justify-content-between">

      <li class="nav-item">
        <a class="nav-link {{ $tab === 'posts' ? 'active' : '' }}" href="?tab=posts">Posts</a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ $tab === 'chapter' ? 'active' : '' }}" href="?tab=chapter">Chapter</a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ $tab === 'whisper' ? 'active' : '' }}" href="?tab=whisper">Whisper</a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ $tab === 'timecapsule' ? 'active' : '' }}" href="?tab=timecapsule">Time Capsule</a>
      </li>

      {{-- TAB Likes hanya muncul jika user login == user yg dilihat --}}
      @if(auth()->id() == $user->id)
      <li class="nav-item">
        <a class="nav-link {{ $tab === 'likes' ? 'active' : '' }}" href="?tab=likes">Likes</a>
      </li>
      @endif

    </ul>

    {{-- === LOAD TAB === --}}
    @include("profile.tabs.$tab")

  </div>
</div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
