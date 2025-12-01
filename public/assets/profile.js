document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;

    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
    }
});

// ===== WATERFALL ANIMATION =====
document.addEventListener("DOMContentLoaded", () => {
  const posts = document.querySelectorAll(".post-card");
  posts.forEach((post, index) => {
    post.style.animationDelay = `${index * 0.2}s`; // delay 0.2s tiap card
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const popup = document.getElementById('popup-success');
  if (popup) {
    // tampilkan popup
    popup.classList.add('show');

    // hilang otomatis setelah 3 detik
    setTimeout(() => {
      popup.classList.remove('show');
      popup.classList.add('hide');

      // hapus elemen setelah animasi
      setTimeout(() => popup.remove(), 400);
    }, 3000);
  }
});

