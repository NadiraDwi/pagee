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
