@extends('user.layouts')

@section('title', 'Tambah Chapter')
@section('nav-chapter', 'active')

@section('content')

{{-- TRIX --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

<style>
/* =========================
   GLOBAL STYLE
========================= */
.form-wrapper {
    max-width: 760px;
    margin: auto;
}

.btn-purple {
    background: #6f42c1;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    transition: .2s;
}
.btn-purple:hover { background:#5933a5; }

.btn-outline-purple {
    border: 2px solid #6f42c1;
    padding: 6px 14px;
    border-radius: 8px;
    background: none;
    color: #6f42c1;
}
.btn-outline-purple:hover { background:#6f42c1; color:white; }

/* =========================
   MUSIC RESULT STYLE
========================= */
.music-box {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 10px;
    background: #fafafa;
}

.play-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    font-size: 16px;
    background: #eee;
}

.add-btn {
    background: transparent;
    border: 2px solid #6f42c1; /* outline */
    color: #6f42c1;
    width: 36px;
    height: 36px;
    border-radius: 50%; /* bikin lingkaran */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.add-btn:hover {
    background: #6f42c1;
    color: white;
}
</style>

<style>
    trix-editor {
        min-height: 250px; /* bebas, bisa 300px atau 400px */
    }
</style>

<style>
/* GROUP MUSIK */
.music-search-group .btn-music-search {
    background: #6f42c1;
    color: #fff;
    padding: 6px 14px;
    font-size: 14px;
    border: none;
    border-radius: 0 8px 8px 0;
    transition: .2s;
}

.music-search-group .btn-music-search:hover {
    background: #5933a5;
}

/* Biar inputnya match */
.music-search-group input {
    border-radius: 8px 0 0 8px;
}
</style>

<style>
/* Tombol khusus pencarian musik */
.music-search-bar .btn-music-search {
    background: #6f42c1;
    color: #fff;
    padding: 6px 14px;
    font-size: 14px;
    border: none;
    border-radius: 0 8px 8px 0;
    transition: .2s;
}

.music-search-bar .btn-music-search:hover {
    background: #5933a5;
}

/* Input biar menyatu bentuknya */
.music-search-bar input {
    border-radius: 8px 0 0 8px;
}

.music-scroll {
    max-height: 300px;       /* bebas atur */
    overflow-y: auto;        /* biar hanya bagian ini yang scroll */
    padding-right: 5px;      /* biar ga kepotong scrollbar */
}

</style>

<div class="d-flex align-items-center mb-3">
    <a href="{{ route('chapter.show', $post->id_post) }}" class="btn btn-outline-purple me-2">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Tambah Chapter Baru</h4>
</div>

<div class="card shadow-sm form-wrapper">
    <div class="card-body">

        <form action="{{ route('chapter.store', $post->id_post) }}" method="POST">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-3">
                <label class="fw-semibold">Judul Chapter</label>
                <input type="text" name="judul_chapter" class="form-control" required>
            </div>

            {{-- MUSIK + SCHEDULE (1 ROW) --}}
            <div class="row">
                
                {{-- MUSIK --}}
                <div class="col-md-7 mb-3">
                    <label class="fw-semibold">Musik (opsional)</label>

                    {{-- MUSIK (1 ROW, TOMBOL 'CARI') --}}
                    <div class="input-group music-search-group">
                        <input type="text" id="music_link" name="link_musik" class="form-control"
                            placeholder="Klik tombol cari untuk memilih musik" readonly>

                        <button type="button" class="btn-music-search" data-bs-toggle="modal" data-bs-target="#musicModal">
                            Cari
                        </button>
                    </div>

                </div>

                {{-- SCHEDULE --}}
                <div class="col-md-5 mb-3">
                    <label class="fw-semibold">Jadwalkan Posting</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control">
                </div>

            </div>

            {{-- ISI --}}
            <div class="mb-3">
                <label class="fw-semibold">Isi Chapter</label>
                <input type="hidden" id="isi_chapter" name="isi_chapter">
                <trix-editor input="isi_chapter"></trix-editor>
            </div>

            <button type="submit" class="btn-purple w-100 mt-3">Simpan Chapter</button>
        </form>

    </div>
</div>



{{-- ==========================
      MODAL MUSIK
========================== --}}
<div class="modal fade" id="musicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cari Musik</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="input-group mb-3 music-search-bar">
                    <input type="text" id="music_query" class="form-control" placeholder="Cari musik...">
                    <button class="btn-music-search" onclick="searchAudius()">Cari</button>
                </div>


                <div id="music_results" class="music-scroll"></div>

                <h6 class="mt-3" id="preview_label" style="display:none;">Preview:</h6>
                <audio id="music_player" controls style="width:100%; display:none;"></audio>

            </div>

        </div>
    </div>
</div>

@endsection



@push('scripts')
<script>

let currentPlaying = null;

/* ================================
   SEARCH AUDIUS
================================ */
function searchAudius() {
    const q = document.getElementById("music_query").value.trim();
    if (!q) return alert("Masukkan kata pencarian!");

    fetch(`/audius/search?q=${encodeURIComponent(q)}`)
        .then(res => res.json())
        .then(data => {
            let html = "";

            if (!data?.data?.length) {
                document.getElementById("music_results").innerHTML =
                    `<p class="text-danger">Tidak ada hasil ditemukan.</p>`;
                return;
            }

            data.data.forEach((track, i) => {
                const url = track.stream?.url || null;

                html += `
                    <div class="music-box d-flex justify-content-between align-items-center">

                        <div>
                            <strong>${track.title}</strong><br>
                            <small>${track.user.name}</small>
                        </div>

                        <div class="d-flex gap-2">
                            ${
                                url
                                ? `
                                    <button id="playBtn${i}" class="play-btn"
                                        onclick="togglePlay('${url}', '${i}')">▶</button>
                                    <button class="add-btn"
                                        onclick="selectMusic('${url}')">+</button>
                                `
                                : `<span class="text-danger">Stream not available</span>`
                            }
                        </div>

                    </div>
                `;
            });

            document.getElementById("music_results").innerHTML = html;
        });
}



/* ================================
   PLAY MUSIC SYSTEM
================================ */
function togglePlay(url, id) {
    const player = document.getElementById("music_player");
    const btn = document.getElementById("playBtn" + id);

    if (currentPlaying === url) {
        player.pause();
        currentPlaying = null;
        btn.innerHTML = "▶";
        return;
    }

    player.src = url;
    player.play();
    currentPlaying = url;

    document.querySelectorAll(".play-btn").forEach(b => b.innerHTML = "▶");
    btn.innerHTML = "⏸";
}

/* ================================
   SELECT MUSIC
================================ */
function selectMusic(url) {
    document.getElementById("music_link").value = url;
    alert("Musik berhasil dipilih!");
}

</script>
@endpush
