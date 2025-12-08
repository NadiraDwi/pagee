@extends('user.layouts')

@section('title', 'Read')
@section('nav-chapter', 'active')

@section('content')
<style>
    .chapter-header {
        margin-bottom: 10px;
    }

    .chapter-title-text {
        font-size: 24px;
        font-weight: 700;
        color: #6f42c1;
    }

    .chapter-subtitle {
        font-size: 14px;
        color: #6c757d;
    }

    .chapter-content {
        font-size: 17px;
        line-height: 1.7;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #eee;
        margin-top: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .nav-buttons {
        margin-top: 30px;
    }

    .btn-purple {
        background: #6f42c1;
        color: #fff;
        border-radius: 8px;
        padding: 8px 18px;
        border: none;
        transition: .2s;
    }

    .btn-purple:hover {
        background: #59339c;
        color: #fff;
    }

    .btn-outline-purple {
        border: 1.8px solid #6f42c1;
        color: #6f42c1;
        padding: 8px 18px;
        font-size: 14px;
        border-radius: 8px;
        background: transparent;
        transition: 0.2s ease;
        text-decoration: none !important;
    }

    .btn-outline-purple:hover {
        background: #6f42c1;
        color: #fff;
    }

    /* Tombol Back */
    .btn-back {
        font-size: 14px;
        color: #6f42c1;
        font-weight: 500;
        text-decoration: none;
        padding: 6px 10px;
        border-radius: 6px;
        display: inline-block;
        transition: .2s;
    }

    .btn-back:hover {
        background: #f1e9ff;
        color: #6f42c1;
    }

    /* Mobile tweaks */
    @media(max-width: 576px) {
        .chapter-content {
            padding: 18px;
            font-size: 16px;
        }
        .chapter-title-text {
            font-size: 20px;
        }
    }
</style>

<div class="container">

    {{-- Back Button --}}
    <a href="{{ route('chapter.show', $post->id_post) }}" class="btn-back">
        &laquo; Kembali ke daftar chapter
    </a>

    {{-- Header --}}
    <div class="chapter-header">
        <h2 class="chapter-title-text">{{ $chapter->judul_chapter }}</h2>
        <small class="chapter-subtitle">
            Bagian dari: <strong>{{ $post->judul }}</strong>
        </small>
    </div>

    {{-- Content --}}
    <div class="chapter-content">
        {!! $chapter->isi_chapter !!}
    </div>

    {{-- Nav --}}
    <div class="d-flex justify-content-between nav-buttons">
        {{-- Prev --}}
        @if ($prev)
            <a href="{{ route('chapter.read', [$post->id_post, $prev->id_chapter]) }}"
               class="btn-outline-purple">
                &laquo; Sebelumnya
            </a>
        @else
            <span></span>
        @endif

        {{-- Next --}}
        @if ($next)
            <a href="{{ route('chapter.read', [$post->id_post, $next->id_chapter]) }}"
               class="btn-outline-purple">
                Selanjutnya &raquo;
            </a>
        @endif
    </div>

</div>

@endsection
