<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audius Music Search</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 40px auto;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            border-radius: 6px;
        }
        button {
            padding: 10px 18px;
            background: #7B2AFF;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            color: white;
            font-weight: bold;
        }
        .track {
            padding: 12px;
            border: 1px solid #eee;
            margin-top: 10px;
            border-radius: 6px;
        }
        .play-btn {
            margin-top: 8px;
            padding: 8px 12px;
            background: #5A1FFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <h2>Audius Music Search (Full Track)</h2>

    <input type="text" id="query" placeholder="Cari musik... (contoh: NIKI)">
    <button onclick="searchMusic()">Search</button>

    <div id="results"></div>

    <h3 style="margin-top:25px;">Player:</h3>
    <audio id="player" controls style="width:100%; margin-top:20px;"></audio>


<script>

    function searchMusic() {
        const q = document.getElementById("query").value.trim();
        if (!q) return alert("Masukkan kata pencarian!");

        fetch(`/audius/search?q=${encodeURIComponent(q)}`)
            .then(res => res.json())
            .then(data => {
                let html = "";

                if (!data || !data.data || data.data.length === 0) {
                    document.getElementById("results").innerHTML =
                        "<p>Tidak ada hasil ditemukan.</p>";
                    return;
                }

                data.data.forEach(track => {

                    // HANDLE jika stream / stream.url tidak ada
                    const streamUrl = track.stream?.url || null;

                    html += `
                        <div class="track">
                            <strong>${track.title}</strong><br>
                            <small>${track.user.name}</small><br>

                            ${streamUrl 
                                ? `<button class="play-btn" onclick="playAudius('${streamUrl}')">Play</button>`
                                : `<p style="color:red;">Stream not available</p>`
                            }
                        </div>
                    `;
                });

                document.getElementById("results").innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                alert("Gagal mengambil data dari server!");
            });
    }


    function playAudius(url) {
        if (!url || url === "null") {
            alert("Stream not available");
            return;
        }

        const player = document.getElementById("player");
        player.src = url;

        player.play()
            .catch(err => {
                console.error(err);
                alert("Gagal memutar audio!");
            });
    }

</script>

</body>
</html>
