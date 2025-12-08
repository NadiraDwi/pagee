@extends('admin.layouts')

@section('title', 'Manajemen Chapter')

@section('content')

@php
  use Illuminate\Support\Str;
  use Carbon\Carbon;
@endphp

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

<style>
    /* === Modal Theme Purple === */
    .bg-purple {
        background: #6f42c1 !important;
    }

    .btn-purple {
        background: #6f42c1;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        transition: .2s;
    }
    .btn-purple:hover {
        background: #5933a5;
        color: #fff;
    }

    .btn-light-purple {
        background: #eee4ff;
        color: #6f42c1;
        border-radius: 8px;
        padding: 8px 16px;
        border: 1px solid #d0bafc;
        transition: .2s;
    }
    .btn-light-purple:hover {
        background: #d6befc;
        color: #fff;
    }

    #confirmDeleteModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }
    #confirmDeleteModal .modal-header {
        border-bottom: none;
    }
    #confirmDeleteModal .modal-footer {
        border-top: none;
    }
</style>

<div class="container">

    {{-- Back Button --}}
    <a href="{{ route('admin.post.chapter.show', $post->id_post) }}" class="btn-back">
        &laquo; Kembali ke daftar chapter
    </a>

    {{-- Content --}}
    <div class="chapter-content">

        {{-- Header --}}
        <div class="chapter-header d-flex justify-content-between align-items-center">

            <div>
                <h2 class="chapter-title-text">{{ $chapter->judul_chapter }}</h2>
                <small class="chapter-subtitle">
                    Bagian dari: <strong>{{ $post->judul }}</strong>
                </small>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    🗑 Hapus Chapter
                </button>
            </div>
        </div>

        {{-- MUSIC PLAYER --}}
        @if ($chapter->link_musik)
            <audio id="chapterMusic" src="{{ $chapter->link_musik }}" loop></audio>

            <button id="playBtn" class="btn btn-outline-purple" 
                style="margin-bottom: 15px; font-size:14px;">
                ▶ Play Music
            </button>
        @endif

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
            <a href="{{ route('admin.post.chapter.read', [$post->id_post, $next->id_chapter]) }}"
               class="btn-outline-purple">
                Selanjutnya &raquo;
            </a>
        @endif
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title fw-bold">Hapus Chapter?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-1">Apakah kamu yakin ingin menghapus chapter ini?</p>
                <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
            </div>

            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-light-purple" data-bs-dismiss="modal">Batal</button>
                
                <form action="{{ route('admin.post.chapter.delete', [$post->id_post, $chapter->id_chapter]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-purple">Ya, Hapus!</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const music = document.getElementById("chapterMusic");
    const playBtn = document.getElementById("playBtn");

    if (!music || !playBtn) return;

    music.volume = 0.85;

    playBtn.textContent = "▶ Play Music";

    playBtn.addEventListener("click", () => {
        if (music.paused) {
            music.play();
            playBtn.textContent = "⏸ Pause Music";
        } else {
            music.pause();
            playBtn.textContent = "▶ Play Music";
        }
    });

    window.addEventListener("beforeunload", () => {
        music.pause();
        music.currentTime = 0;
    });
});
</script>

@endsection
