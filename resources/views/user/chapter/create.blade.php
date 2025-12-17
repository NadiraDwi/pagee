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
    padding: 0 15px; 
}

/* Buttons */
.btn-purple { 
    background: #6f42c1; 
    color: white; 
    border: none; 
    padding: 10px 18px; 
    border-radius: 8px; 
    transition: .2s; 
}
.btn-purple:hover { 
    background:#5933a5; 
}
.btn-outline-purple { 
    border: 2px solid #6f42c1; 
    padding: 6px 14px; 
    border-radius: 8px; 
    background: none; 
    color: #6f42c1; 
    transition: .2s;
}
.btn-outline-purple:hover { 
    background:#6f42c1; 
    color:white; 
}

/* =========================
   MUSIC RESULT STYLE
========================= */
.music-box { 
    border: 1px solid #ddd; 
    border-radius: 10px; 
    padding: 12px; 
    margin-bottom: 10px; 
    background: #fafafa; 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    transition: .2s;
}
.music-box:hover { 
    background: #f0f0f0; 
}

/* Play Button */
.play-btn { 
    width: 36px; 
    height: 36px; 
    border-radius: 50%; 
    border: none; 
    font-size: 16px; 
    background: #eee; 
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .2s;
}
.play-btn:hover { background: #dcdcdc; }

/* Add Button */
.add-btn { 
    background: transparent; 
    border: 2px solid #6f42c1; 
    color: #6f42c1; 
    width: 36px; 
    height: 36px; 
    border-radius: 50%; 
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

/* Trix editor */
trix-editor { 
    min-height: 250px; 
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 10px;
    transition: .2s;
}
trix-editor:focus { border-color: #6f42c1; outline: none; }

/* GROUP MUSIK */
.music-search-group .btn-music-search,
.music-search-bar .btn-music-search { 
    background: #6f42c1; 
    color: #fff; 
    padding: 6px 14px; 
    font-size: 14px; 
    border: none; 
    border-radius: 0 8px 8px 0; 
    transition: .2s; 
}
.music-search-group .btn-music-search:hover,
.music-search-bar .btn-music-search:hover { 
    background: #5933a5; 
}
.music-search-group input, .music-search-bar input { 
    border-radius: 8px 0 0 8px; 
    padding: 6px 10px;
    border: 1px solid #ddd;
}

/* Scrollable music list */
.music-scroll { 
    max-height: 300px; 
    overflow-y: auto; 
    padding-right: 5px; 
}

/* Toast Notifications */
.music-toast { 
    position: fixed; 
    bottom: 20px; 
    right: 20px; 
    background: #6f42c1; 
    color: #fff; 
    padding: 12px 20px; 
    border-radius: 10px; 
    font-weight: 500; 
    opacity: 0; 
    transform: translateY(20px); 
    transition: .3s ease; 
    z-index: 2000; 
    box-shadow: 0 4px 12px rgba(111,66,193,0.35);
}
.music-toast.show { 
    opacity: 1; 
    transform: translateY(0); 
}

/* =========================
   RESPONSIVE ADJUSTMENTS
========================= */
@media(max-width: 576px) {
    .music-box { 
        flex-direction: column; 
        align-items: flex-start; 
        padding: 10px; 
    }
    .play-btn, .add-btn { width: 32px; height: 32px; font-size: 14px; }
    .music-search-group input, .music-search-bar input { width: 100%; margin-bottom: 6px; }
}

/* =========================
   DARK MODE
========================= */
body.dark-mode {
    background-color: #121212;
    color: #e5e7eb;
}

body.dark-mode .music-box {
    background: #1f1f1f;
    border: 1px solid #333;
}
body.dark-mode .music-box:hover { background: #2a2a2a; }

body.dark-mode .play-btn { background: #2a2a2a; color: #e5e7eb; }
body.dark-mode .play-btn:hover { background: #3a3a3a; }

body.dark-mode .add-btn { border-color: #bb86fc; color: #bb86fc; }
body.dark-mode .add-btn:hover { background: #bb86fc; color: #121212; }

body.dark-mode trix-editor { background: #1f1f1f; color: #e5e7eb; border-color: #333; }
body.dark-mode trix-editor:focus { border-color: #bb86fc; }

body.dark-mode .music-search-group input, 
body.dark-mode .music-search-bar input { 
    background: #1f1f1f; 
    color: #e5e7eb; 
    border: 1px solid #333; 
}

body.dark-mode .music-search-group .btn-music-search,
body.dark-mode .music-search-bar .btn-music-search { 
    background: #bb86fc; 
    color: #121212; 
}
body.dark-mode .music-search-group .btn-music-search:hover,
body.dark-mode .music-search-bar .btn-music-search:hover { 
    background: #9b5ed3; 
    color: #fff; 
}

body.dark-mode .music-toast { background: #bb86fc; color: #121212; box-shadow: 0 4px 12px rgba(187,134,252,0.35); }

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
</style>

{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')

{{-- Back Button --}}
    <a href="{{ route('chapter.show', $post->id_post) }}" class="btn-back">
        &laquo; Kembali ke daftar chapter
    </a>
<div class="d-flex align-items-center mb-3">
    <h4 class="fw-bold mb-0">Tambah Chapter Baru</h4>
</div>

<div class="card shadow-sm form-wrapper">
    <div class="card-body">

        <form id="chapterForm" action="{{ route('chapter.store', $post->id_post) }}" method="POST">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-3">
                <label class="fw-semibold">Judul Chapter</label>
                <input type="text" name="judul_chapter" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            {{-- MUSIK + SCHEDULE --}}
            <div class="row">
                {{-- MUSIK --}}
                <div class="col-md-7 mb-3">
                    <label class="fw-semibold">Musik (opsional)</label>
                    <div class="input-group music-search-group">
                        <input type="text" id="music_link" name="link_musik" class="form-control" placeholder="Klik tombol cari untuk memilih musik" readonly>
                        <button type="button" class="btn-music-search" data-bs-toggle="modal" data-bs-target="#musicModal">Cari</button>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>

                {{-- SCHEDULE --}}
                <div class="col-md-5 mb-3">
                    <label class="fw-semibold">Jadwalkan Posting</label>
                    <input
                        type="datetime-local"
                        name="scheduled_at"
                        class="form-control"
                        id="scheduled_at"
                    >
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            {{-- ISI --}}
            <div class="mb-3">
                <label class="fw-semibold">Isi Chapter</label>
                <input type="hidden" id="isi_chapter" name="isi_chapter">
                <trix-editor input="isi_chapter"></trix-editor>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="btn-purple w-100 mt-3">Simpan Chapter</button>
        </form>

    </div>
</div>

{{-- =========================
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
                    <button class="btn-music-search" type="button" onclick="searchAudius()">Cari</button>
                </div>

                <div id="music_results" class="music-scroll"></div>

                <h6 class="mt-3" id="preview_label" style="display:none;">Preview:</h6>
                <audio id="music_player" controls style="width:100%; display:none;"></audio>

            </div>

        </div>
    </div>
</div>

<div id="musicToast" class="music-toast"><span id="musicToastMessage"></span></div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ====================
    // FORM VALIDATION
    // ====================
    const form = document.getElementById('chapterForm');
    const judul = form.querySelector('[name="judul_chapter"]');
    const isi = form.querySelector('[name="isi_chapter"]');
    const musik = form.querySelector('[name="link_musik"]');
    const schedule = form.querySelector('[name="scheduled_at"]');

    // Tambah div invalid-feedback jika belum ada
    function addErrorDiv(input){
        let div = input.parentNode.querySelector('.invalid-feedback');
        if(!div){
            div = document.createElement('div');
            div.className = 'invalid-feedback';
            input.parentNode.appendChild(div);
        }
        return div;
    }
    const judulError = addErrorDiv(judul);
    const isiError = addErrorDiv(isi);
    const musikError = addErrorDiv(musik);
    const scheduleError = addErrorDiv(schedule);

    form.addEventListener('submit', function(e){
        let valid = true;

        // Judul
        if(judul.value.trim() === ''){
            judul.classList.add('is-invalid');
            judulError.textContent = 'Judul Chapter wajib diisi';
            valid = false;
        } else if(judul.value.length > 255){
            judul.classList.add('is-invalid');
            judulError.textContent = 'Judul maksimal 255 karakter';
            valid = false;
        } else {
            judul.classList.remove('is-invalid');
            judulError.textContent = '';
        }

        // Isi
        if(isi.value.trim() === ''){
            isi.classList.add('is-invalid');
            isiError.textContent = 'Isi Chapter wajib diisi';
            valid = false;
        } else {
            isi.classList.remove('is-invalid');
            isiError.textContent = '';
        }

        // Musik
        if(musik.value && musik.value.length > 10000){
            musik.classList.add('is-invalid');
            musikError.textContent = 'Link musik terlalu panjang';
            valid = false;
        } else {
            musik.classList.remove('is-invalid');
            musikError.textContent = '';
        }

        // Schedule
        if(schedule.value){
            const selectedDate = new Date(schedule.value);
            const now = new Date();
            if(selectedDate <= now){
                schedule.classList.add('is-invalid');
                scheduleError.textContent = 'Tanggal harus setelah sekarang';
                valid = false;
            } else {
                schedule.classList.remove('is-invalid');
                scheduleError.textContent = '';
            }
        } else {
            schedule.classList.remove('is-invalid');
            scheduleError.textContent = '';
        }

        if(!valid){
            e.preventDefault();
            e.stopPropagation();
        }
    });

    // ====================
    // MUSIC SYSTEM
    // ====================
    let currentPlaying = null;

    window.searchAudius = function(){
        const q = document.getElementById("music_query").value.trim();
        if(!q) return showMusicToast("Masukkan kata pencarian!");

        fetch(`/audius/search?q=${encodeURIComponent(q)}`)
            .then(res=>res.json())
            .then(data=>{
                let html = '';
                if(!data?.data?.length){
                    document.getElementById("music_results").innerHTML = '<p class="text-danger">Tidak ada hasil ditemukan.</p>';
                    return;
                }
                data.data.forEach((track,i)=>{
                    const url = track.stream?.url || null;
                    html += `<div class="music-box d-flex justify-content-between align-items-center">
                        <div><strong>${track.title}</strong><br><small>${track.user.name}</small></div>
                        <div class="d-flex gap-2">
                        ${ url 
                            ? `<button id="playBtn${i}" class="play-btn" onclick="togglePlay('${url}','${i}')">▶</button>
                               <button class="add-btn" onclick="selectMusic('${url}')">+</button>`
                            : `<span class="text-danger">Stream not available</span>` }
                        </div></div>`;
                });
                document.getElementById("music_results").innerHTML = html;
            });
    }

    window.togglePlay = function(url,id){
        const player = document.getElementById("music_player");
        const btn = document.getElementById("playBtn"+id);

        if(currentPlaying === url){
            player.pause();
            currentPlaying = null;
            btn.innerHTML = "▶";
            return;
        }

        player.src = url;
        player.play();
        currentPlaying = url;
        document.querySelectorAll(".play-btn").forEach(b=>b.innerHTML="▶");
        btn.innerHTML = "⏸";
    }

    window.selectMusic = function(url){
        document.getElementById("music_link").value = url;
        const player = document.getElementById("music_player");
        player.pause();
        currentPlaying = null;
        document.querySelectorAll(".play-btn").forEach(b=>b.innerHTML="▶");

        const modal = bootstrap.Modal.getInstance(document.getElementById('musicModal'));
        modal.hide();
        showMusicToast("Musik berhasil ditambahkan!");
    }

    function showMusicToast(text){
        const toastBox = document.getElementById("musicToast");
        const toastMsg = document.getElementById("musicToastMessage");
        toastMsg.innerText = text;
        toastBox.classList.add("show");
        setTimeout(()=> toastBox.classList.remove("show"),2500);
    }

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('scheduled_at');

    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

    input.min = now.toISOString().slice(0, 16);
});
</script>

@endpush
