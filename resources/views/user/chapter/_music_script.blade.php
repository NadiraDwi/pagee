<script>

let currentPlaying = null;

/* ================================
   SEARCH AUDIUS
================================ */
function searchAudius() {
    const q = document.getElementById("music_query").value.trim();
    if (!q) return showMusicAlert("Masukkan kata pencarian!", "danger");

    fetch(`/audius/search?q=${encodeURIComponent(q)}`)
        .then(res => res.json())
        .then(data => {
            let html = "";

            if (!data?.data?.length) {
                return document.getElementById("music_results").innerHTML =
                    `<p class="text-danger">Tidak ada hasil ditemukan.</p>`;
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
   SELECT MUSIC (AUTO CLOSE + PAUSE)
================================ */
function selectMusic(url) {
    document.getElementById("music_link").value = url;

    const player = document.getElementById("music_player");
    player.pause();
    currentPlaying = null;

    document.querySelectorAll(".play-btn").forEach(b => b.innerHTML = "▶");

    // Tutup modal pencarian
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalMusic"));
    modal.hide();

    // Tampilkan modal sukses
    showMusicAlert("Musik berhasil ditambahkan!", "success");
}



/* ================================
   MINI MODAL SUCCESS (PURPLE STYLE)
================================ */
function showMusicAlert(message, type = "success") {
    const box = document.getElementById("musicNotifBox");

    box.innerHTML = `
        <div class="music-alert music-alert-${type}">
            ${message}
        </div>
    `;

    setTimeout(() => box.innerHTML = "", 2000);
}

</script>

<style>
/* Alert mini */
.music-alert {
    padding: 10px 15px;
    border-radius: 8px;
    color: #fff;
    text-align: center;
    font-weight: 600;
    animation: fadeSlide 0.3s ease;
}

.music-alert-success { background: #7c4dff; }   /* Ungu */
.music-alert-danger { background: #d63031; }

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
