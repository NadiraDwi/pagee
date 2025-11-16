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
});
