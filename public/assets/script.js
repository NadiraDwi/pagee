// =========================================================
//  PAGEE - GLOBAL SCRIPT
// =========================================================

document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const toggleBtn = document.getElementById("modeToggle");
  const toggleIcon = toggleBtn ? toggleBtn.querySelector("i") : null;

  // ====== TOGGLE MODE TERANG/GELAP ======
  if (toggleBtn) {
    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
      if (toggleIcon) toggleIcon.classList.replace("fa-moon", "fa-sun");
    }

    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("dark-mode");
      const isDark = body.classList.contains("dark-mode");
      if (toggleIcon) {
        toggleIcon.classList.toggle("fa-moon", !isDark);
        toggleIcon.classList.toggle("fa-sun", isDark);
      }
      localStorage.setItem("theme", isDark ? "dark" : "light");
    });
  }

  // ====== CUSTOM MUSIC BUTTON ======
  document.querySelectorAll(".music-btn").forEach((btn) => {
    const audioId = btn.getAttribute("data-audio");
    const audio = document.getElementById(audioId);
    const icon = btn.querySelector("i");

    if (!audio || !icon) return;

    btn.addEventListener("click", () => {
      document.querySelectorAll("audio").forEach((a) => {
        if (a !== audio) {
          a.pause();
          a.currentTime = 0;
          const otherBtn = document.querySelector(
            `.music-btn[data-audio="${a.id}"] i`
          );
          if (otherBtn) otherBtn.classList.replace("fa-pause", "fa-play");
        }
      });

      if (audio.paused) {
        audio.play();
        icon.classList.replace("fa-play", "fa-pause");
      } else {
        audio.pause();
        icon.classList.replace("fa-pause", "fa-play");
      }

      audio.addEventListener("ended", () => {
        icon.classList.replace("fa-pause", "fa-play");
      });
    });
  });

  // ====== SHORT/LONG POST MODAL & FORM ======
  const postTypeModalEl = document.getElementById("postTypeModal");
  const postTypeModal = new bootstrap.Modal(postTypeModalEl);
  const placeholder = document.getElementById("shortPostPlaceholder");
  const shortPostBtn = document.getElementById("shortPostBtn");
  const longPostBtn = document.getElementById("longPostBtn");
  const shortPostForm = document.getElementById("shortPostForm");

  if (placeholder && postTypeModalEl && shortPostBtn && longPostBtn && shortPostForm) {
    // Klik placeholder → buka modal
    placeholder.addEventListener("click", () => {
      postTypeModal.show();
    });

    // Short Post → tutup modal & tampilkan form
    shortPostBtn.addEventListener("click", () => {
      postTypeModal.hide();
      shortPostForm.style.display = "block";
      shortPostForm.querySelector("textarea").focus();
    });

    // Long Post → redirect (gunakan attribute data-url dari HTML)
    longPostBtn.addEventListener("click", () => {
      const url = longPostBtn.getAttribute("data-url");
      if (url) {
        window.location.href = url;
      }
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
  const shortPostForm = document.getElementById("shortPostFormAjax");
  const feedPosts = document.getElementById("feedPosts");

  shortPostForm.addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const token = document.querySelector('input[name="_token"]').value;

    fetch(this.action, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": token,
        "X-Requested-With": "XMLHttpRequest"
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        // Buat elemen post baru
        const postHtml = `
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <img src="https://randomuser.me/api/portraits/men/1.jpg" class="rounded-circle me-2" width="45" height="45" alt="">
              <div>
                <strong>@${data.post.user}</strong><br>
                <small class="text-muted">${data.post.created_at}</small>
              </div>
            </div>
            <p>${data.post.isi}</p>
            <div class="d-flex gap-4">
              <button class="btn btn-link p-0 text-muted"><i class="fa-regular fa-comment"></i></button>
              <button class="btn btn-link p-0 text-muted"><i class="fa-regular fa-heart"></i></button>
              <button class="btn btn-link p-0 text-muted"><i class="fa-solid fa-share-nodes"></i></button>
            </div>
          </div>
        </div>
        `;

        // Masukkan post baru di atas feed
        feedPosts.insertAdjacentHTML('afterbegin', postHtml);

        // Reset form
        shortPostForm.reset();
      }
    })
    .catch(err => console.error(err));
  });
});

// === Character Counter ===
const textarea = document.getElementById('inputPost');
const charCount = document.getElementById('charCount');

textarea.addEventListener('input', () => {
    charCount.textContent = textarea.value.length;
});

// === Mention System ===
const mentionList = document.getElementById("mentionList");
const mentionItems = document.querySelectorAll(".mention-item");
const selectedMention = document.getElementById("selectedMention");
const mentionData = document.getElementById("mentionData");

let mentions = [];

textarea.addEventListener("keyup", (e) => {
    const val = textarea.value;
    const lastChar = val.slice(-1);

    if (lastChar === "@") {
        mentionList.classList.remove("d-none");
    } else if (!val.includes("@")) {
        mentionList.classList.add("d-none");
    }
});

mentionItems.forEach(item => {
    item.addEventListener("click", () => {
        const username = item.dataset.username;

        // tampilin chip
        if (!mentions.includes(username)) {
            mentions.push(username);

            let chip = document.createElement("span");
            chip.classList = "badge bg-purple text-white px-2 py-1";
            chip.textContent = "@" + username;
            selectedMention.appendChild(chip);

            mentionData.value = JSON.stringify(mentions);
        }

        mentionList.classList.add("d-none");
    });
});

// ADD PEOPLE FEATURE
(function() {
    const btn = document.getElementById("addPeopleBtn");
    const box = document.getElementById("peopleBox");
    const mentionsInput = document.getElementById("mentionsInput");
    const search = document.getElementById("peopleSearch");
    const listItems = document.querySelectorAll(".user-item");

    // Kalau bukan di halaman short post, hentikan
    if (!btn || !box || listItems.length === 0) return;

    let selected = [];

    // Toggle box
    btn.addEventListener("click", () => {
        box.classList.toggle("d-none");
    });

    // Pilih user
    listItems.forEach(item => {
        item.addEventListener("click", function() {
            const id = this.dataset.id;

            if (!selected.includes(id)) {
                selected.push(id);
                this.classList.add("active");
            } else {
                selected = selected.filter(x => x !== id);
                this.classList.remove("active");
            }

            mentionsInput.value = JSON.stringify(selected);
        });
    });

    // Search user
    if (search) {
        search.addEventListener("keyup", function() {
            const q = this.value.toLowerCase();
            listItems.forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(q)
                    ? "block" : "none";
            });
        });
    }
})();

// ===== WATERFALL POST-CARD ANIMATION =====
document.addEventListener("DOMContentLoaded", () => {
    const posts = document.querySelectorAll(".post-card");
    posts.forEach((post, index) => {
        post.style.animationDelay = `${index * 0.15}s`;
    });

    const covers = document.querySelectorAll(".post-cover");
    covers.forEach((cover, index) => {
        cover.style.animationDelay = `${0.3 + index * 0.15}s`;
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById('welcome-popup');
    if(popup){
        popup.classList.add('active');

        setTimeout(() => {
            popup.classList.remove('active');
        }, 2500); // tampil 2.5 detik
    }
});

});
