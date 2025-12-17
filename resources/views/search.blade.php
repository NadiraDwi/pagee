@extends('user.layouts')

@section('title', 'Hasil Pencarian')
@section('nav-home', 'active')

@section('content')
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
@if(session('justLoggedIn'))
    <div id="welcome-screen" class="welcome-screen">
        <div class="welcome-content">
            <img src="{{ asset('assets/image/whale2.png') }}" alt="Whale" class="whale">
            <h1 class="welcome-text" id="welcomeText">
                {{ "Welcome, " . Auth::user()->nama . ", wanderer of dreams ✨" }}
            </h1>
            <p class="welcome-subtext">Every idea you have is a wave waiting to dance 🌊</p>
        </div>
    </div>
@endif

{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')

<div class="container mt-0">
    <h3 class="mb-3">Hasil Pencarian: "{{ $query }}"</h3>

    @if($posts->isEmpty() && $chapters->isEmpty() && $profiles->isEmpty())
        <p class="text-muted">Tidak ada hasil ditemukan.</p>
    @endif

    {{-- PROFILE --}}
    @if($profiles->isNotEmpty())
        <h4 class="text-purple mb-2 mt-4">Profile</h4>
        @foreach($profiles as $profile)
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-wrapper me-2">
                    <img src="{{ $profile->foto ? asset('storage/' . $profile->foto) : 'https://i.pravatar.cc/45' }}" 
                         class="rounded-circle me-3" width="45">
                    </div>
                    <div>
                        <a href="{{ route('user.profile', $profile->id_user) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $profile->nama }}
                        </a>
                        <p class="text-muted mb-0" style="font-size: 13px;">@ {{ $profile->username }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- CHAPTER --}}
    @if($chapters->isNotEmpty())
        <h4 class="text-purple mb-2 mt-4">Chapter</h4>
        @foreach($chapters as $chapter)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <a href="{{ route('chapter.read', [$chapter->id_post, $chapter->id_chapter]) }}" class="text-decoration-none text-dark fw-bold">
                        {{ $chapter->judul_chapter }}
                    </a>
                    <p class="text-muted mb-0" style="font-size: 14px;">
                        {{ Str::limit(strip_tags($chapter->isi_chapter), 150, '...') }}
                    </p>
                </div>
            </div>
        @endforeach
    @endif

</div>

@endsection
