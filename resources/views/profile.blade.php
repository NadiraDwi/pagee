<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

  <!-- CSS Global -->
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
  <!-- CSS Profile -->
  <link rel="stylesheet" href="{{ asset('assets/profile.css') }}">
</head>
<body>

<!-- ===== HEADER ===== -->
<div class="profile-header"></div>

<div class="container mt-3">

  <div class="d-flex justify-content-between align-items-start">
    <img 
      src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://via.placeholder.com/120' }}"
      class="profile-picture"
      alt="Profile Picture"
    >

    <a href="{{ route('profile.edit') }}" class="btn-edit-profile mt-2">
      <i class="fa-solid fa-pen me-1"></i> Edit Profile
    </a>
  </div>

  <div class="mt-3 profile-page-text">
    <h4 class="fw-bold">{{ $user->nama }}</h4>
    <p class="username">@{{ $user->nama }}</p>

    @if($user->bio)
      <p class="mt-2">{{ $user->bio }}</p>
    @else
      <p class="mt-2 text-muted"><i>Belum ada bio</i></p>
    @endif

    <p class="text-muted mt-2">
      <i class="fa-regular fa-calendar"></i>
      Joined {{ $user->created_at->format('F Y') }}
    </p>
  </div>

  <a href="/home" class="btn-purple mt-4">
    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda
  </a>

</div>

<!-- JS Bootstrap & Global Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/script.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;

  // Inisialisasi mode
  if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark");
  } else {
    body.classList.add("light");
  }

  // Tombol toggle mode (global, pastikan ada di navbar)
  const toggleBtn = document.getElementById("modeToggle");
  const toggleIcon = toggleBtn ? toggleBtn.querySelector("i") : null;

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      if (body.classList.contains("dark")) {
        body.classList.replace("dark", "light");
        localStorage.setItem("theme", "light");
      } else {
        body.classList.replace("light", "dark");
        localStorage.setItem("theme", "dark");
      }
      if (toggleIcon) toggleIcon.classList.toggle("fa-moon");
      if (toggleIcon) toggleIcon.classList.toggle("fa-sun");
    });
  }
});
</script>
</body>
</html>
