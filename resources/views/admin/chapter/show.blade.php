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
.chapter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-radius: 10px;
    border: 1px solid #eee;
    background: #fff;
    transition: 0.2s ease;
    text-decoration: none;
    color: inherit;
}
.chapter-row:hover {
    background: #f6f1ff;
    border-color: #d9c9ff;
    cursor: pointer;
}
.chapter-number { font-weight: 600; color: #6f42c1; }
.chapter-title { flex:1; margin-left:12px; font-weight:500; color:#000; }
.btn-outline-purple {
    border:1.8px solid #6f42c1; color:#6f42c1; padding:5px 14px; font-size:14px;
    border-radius:8px; background:transparent; transition:0.2s; text-decoration:none !important;
}
.btn-outline-purple:hover { background:#6f42c1; color:#fff; }
.header-cover {
    width:100%; height:220px; border-radius:12px; background-size:cover; background-position:center;
    background-repeat:no-repeat; margin-bottom:20px; position:relative; overflow:hidden;
}
.header-cover::after {
    content:""; position:absolute; inset:0; background:rgba(0,0,0,0.35);
}
.header-title { position:absolute; bottom:15px; left:20px; z-index:2; color:white; font-size:22px; font-weight:700; }
</style>

{{-- HEADER COVER --}}
<div class="header-cover" style="background-image: url('{{ asset('storage/'.$post->cover->cover_path) }}')">
    <div class="header-title">{{ $post->judul }}</div>
</div>

<!-- Updated view with tabs for Author Info and Chapters -->
<!-- You can paste this into your Blade view and adapt as needed -->

<div class="container">

  <!-- TABS NAV -->
  <ul class="nav nav-tabs mb-3" id="chapterTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="author-tab" data-bs-toggle="tab" data-bs-target="#authorTab" type="button" role="tab">Author</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="chapter-tab" data-bs-toggle="tab" data-bs-target="#chapterTabContent" type="button" role="tab">Chapters</button>
    </li>
  </ul>

  <style>
    .nav-tabs .nav-link.active {
        color: #6f42c1 !important;
        font-weight: 600;
    }
    #authorTab strong {
        color: #6f42c1;
    }

    .chapter-title a { color:#000 !important; text-decoration:none !important; }
</style>

  <!-- TAB CONTENT -->
  <div class="tab-content" id="chapterTabContentWrapper">

    <!-- TAB 1: AUTHOR INFO -->
    <div class="tab-pane fade show active p-3" id="authorTab" role="tabpanel">
        <div class="mb-3">
            <strong>Penulis:</strong> {{ $post->user->nama }}<br>
            <small>Email: {{ $post->user->email }}</small><br>

        @if($post->collabs->count() > 0)
            <strong>Collaborators:</strong><br>
                @foreach($post->collabs as $c)
                    {{ $c->user2->nama }} — <small>{{ $c->user2->email }}</small><br>
                @endforeach
        @endif

        <strong>Tanggal Terbit: </strong><small>{{ $post->created_at->format('d M Y H:i') }}</small>
        </div>

        <hr>
        <strong>Sinopsis</strong>
        <div class="mt-2" style="text-align: justify;">{!! nl2br(e($post->isi)) !!}</div>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <button class="btn btn-danger btn-sm" onclick="deletePostModal({{ $post->id_post }})">Hapus Postingan</button>
        </div>
    </div>

    <!-- TAB 2: CHAPTER LIST -->
    <div class="tab-pane fade p-3" id="chapterTabContent" role="tabpanel">

    {{-- List Chapter --}}
    <div class="d-flex flex-column gap-2">
    @forelse ($chapters as $i => $chapter)
        @php
            $isBeforeRelease = $chapter->scheduled_at?->isFuture() ?? false;
            $isRestricted = !($isOwner || $isCollaborator) && $isBeforeRelease;
        @endphp

        <div class="chapter-row {{ $isRestricted ? 'bg-light text-muted' : '' }}" 
            style="{{ $isRestricted ? 'cursor:not-allowed; opacity:.7;' : '' }}">
            
            <div class="chapter-number">Chapter {{ $i+1 }}</div>

            <div class="chapter-title">
                @if($isRestricted)
                    {{ $chapter->judul_chapter }}
                @else
                    <a href="{{ route('admin.post.chapter.read', [$post->id_post, $chapter->id_chapter]) }}">
                        {{ $chapter->judul_chapter }}
                    </a>
                @endif
            </div>

            @if($chapter->scheduled_at)
                <span class="badge {{ $isBeforeRelease ? 'bg-warning text-dark' : '' }}" style="font-size:11px;">
                    @if($isBeforeRelease)
                        Rilis pada {{ $chapter->scheduled_at->format('d M Y H:i') }}
                    @endif
                </span>
            @endif
        </div>
    @empty
        <p class="text-muted">Belum ada chapter.</p>
    @endforelse
    </div>

        <div id="chapterLoopPlaceholder"></div>
    </div>

  </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Hapus post dari modal
function deletePostModal(id) {
    Swal.fire({
        title: "Hapus postingan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
    }).then((res)=>{
        if(res.isConfirmed){
            $.ajax({
                url: '/admin/post/delete/' + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(){
                    Swal.fire({
                        title: "Berhasil",
                        text: "Postingan dihapus",
                        icon: "success"
                    }).then(() => {
                        window.location.href = "{{ route('admin.post.chapter') }}";
                    });
                },
                error: function(){
                    Swal.fire("Gagal", "Terjadi kesalahan", "error");
                }
            });
        }
    });
}
</script>
