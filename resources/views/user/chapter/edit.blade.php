@extends('user.layouts')

@section('title', 'Edit Chapter')
@section('nav-chapter', 'active')

@section('content')

{{-- TRIX --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

<style>
/* ========== (COPY STYLE DARI CREATE) ========== */
.form-wrapper { max-width: 760px; margin: auto; }
.btn-purple { background:#6f42c1; color:white; border:none; padding:10px 18px; border-radius:8px; transition:.2s; }
.btn-purple:hover { background:#5933a5; }
.btn-outline-purple { border:2px solid #6f42c1; padding:6px 14px; border-radius:8px; background:none; color:#6f42c1; }
.btn-outline-purple:hover { background:#6f42c1; color:white; }
.music-box { border:1px solid #ddd; border-radius:10px; padding:12px; margin-bottom:10px; background:#fafafa; }
.play-btn { width:36px; height:36px; border-radius:50%; border:none; font-size:16px; background:#eee; }
.add-btn { background:transparent; border:2px solid #6f42c1; color:#6f42c1; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; cursor:pointer; transition:.2s; }
.add-btn:hover { background:#6f42c1; color:white; }
trix-editor { min-height:250px; }
.music-search-bar .btn-music-search { background:#6f42c1; color:#fff; padding:6px 14px; font-size:14px; border:none; border-radius:0 8px 8px 0; transition:.2s; }
.music-search-bar .btn-music-search:hover { background:#5933a5; }
.music-search-bar input { border-radius:8px 0 0 8px; }
.music-scroll { max-height:300px; overflow-y:auto; padding-right:5px; }
</style>

<div class="d-flex align-items-center mb-3">
    <a href="{{ route('chapter.show', $post->id_post) }}" class="btn btn-outline-purple me-2">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Edit Chapter</h4>
</div>

<div class="card shadow-sm form-wrapper">
    <div class="card-body">

        <form action="{{ route('chapter.update', [$post->id_post, $chapter->id_chapter]) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- JUDUL --}}
            <div class="mb-3">
                <label class="fw-semibold">Judul Chapter</label>
                <input type="text" name="judul_chapter" class="form-control" value="{{ $chapter->judul_chapter }}" required>
            </div>

            {{-- MUSIK + SCHEDULE --}}
            <div class="row">
                <div class="col-md-7 mb-3">
                    <label class="fw-semibold">Musik (opsional)</label>

                    <div class="input-group music-search-group">
                        <input type="text" id="music_link" name="link_musik" class="form-control"
                            value="{{ $chapter->link_musik }}" placeholder="Klik cari untuk memilih musik" readonly>

                        <button type="button" class="btn-music-search" data-bs-toggle="modal" data-bs-target="#musicModal">
                            Cari
                        </button>
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <label class="fw-semibold">Jadwalkan Posting</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control"
                        value="{{ $chapter->scheduled_at ? date('Y-m-d\TH:i', strtotime($chapter->scheduled_at)) : '' }}">
                </div>
            </div>

            {{-- ISI --}}
            <div class="mb-3">
                <label class="fw-semibold">Isi Chapter</label>
                <input type="hidden" id="isi_chapter" name="isi_chapter" value="{{ $chapter->isi_chapter }}">
                <trix-editor input="isi_chapter"></trix-editor>
            </div>

            <button type="submit" class="btn-purple w-100 mt-3">Update Chapter</button>
        </form>

    </div>
</div>

{{-- ========= MODAL MUSIK (SAMA DENGAN CREATE) ========= --}}
@include('user.chapter._music_modal')

@endsection

@push('scripts')
@include('user.chapter._music_script')
@endpush
