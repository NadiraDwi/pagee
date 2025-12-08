<script>

let currentPlaying = null;

/* ================================
   SEARCH AUDIUS (API CALL)
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
   PLAY / PAUSE FUNCTION
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

    document.getElementById("preview_label").style.display = "block";
    document.getElementById("music_player").style.display = "block";
}



/* ================================
   SELECT MUSIC
================================ */
function selectMusic(url) {
    document.getElementById("music_link").value = url;
    alert("Musik berhasil dipilih!");
}

</script>
