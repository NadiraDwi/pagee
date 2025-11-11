// =========================================================
//  PAGEE - GLOBAL SCRIPT
// =========================================================

// Jalankan semua setelah DOM siap
document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const toggleBtn = document.getElementById("modeToggle");
  const toggleIcon = toggleBtn ? toggleBtn.querySelector("i") : null;

  // ====== TOGGLE MODE TERANG/GELAP ======
  if (toggleBtn) {
    // Cek preferensi tema sebelumnya
    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
      if (toggleIcon) toggleIcon.classList.replace("fa-moon", "fa-sun");
    }

    // Tombol ubah mode
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
      // pause semua audio lain biar gak tumpuk
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

      // toggle play/pause
      if (audio.paused) {
        audio.play();
        icon.classList.replace("fa-play", "fa-pause");
      } else {
        audio.pause();
        icon.classList.replace("fa-pause", "fa-play");
      }

      // ubah ikon balik saat audio selesai
      audio.addEventListener("ended", () => {
        icon.classList.replace("fa-pause", "fa-play");
      });
    });
  });

  // ====== ANIMASI FADE-IN LOGIN PAGE ======
  const loginCard = document.querySelector(".login-card");
  if (loginCard) {
    loginCard.style.opacity = 0;
    loginCard.style.transform = "translateY(30px)";
    setTimeout(() => {
      loginCard.style.transition = "0.6s ease";
      loginCard.style.opacity = 1;
      loginCard.style.transform = "translateY(0)";
    }, 100);
  }
});
