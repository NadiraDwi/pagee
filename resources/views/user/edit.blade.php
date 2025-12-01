<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit Profile — Pastel Dark</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

<!-- Custom CSS (Pastel dark + glassmorphism) -->
<link rel="stylesheet" href="{{ asset('assets/profile-edit.css') }}">

<!-- Pass routes & csrf to JS -->
<script>
  const usernameCheckUrl = "{{ route('profile.checkUsername') }}";
  const csrfToken = "{{ csrf_token() }}";
</script>
</head>
<body class="pastel-dark">

<!-- SKELETON LOADING -->
<div id="skeleton" class="skeleton-root" aria-hidden="true">
  <div class="skeleton-cover shimmer"></div>
  <div class="skeleton-photo shimmer"></div>
  <div class="skeleton-card shimmer"></div>
</div>

<!-- TOPBAR -->
<header class="topbar">
  <div class="container d-flex justify-content-end py-2">
    <div class="me-3 text-muted small">Theme</div>
    <button id="modeToggle" class="btn btn-mode" aria-label="Toggle theme">
      <i id="modeIcon" class="fa-solid fa-sun"></i>
    </button>
  </div>
</header>

<main class="container page-wrap">
  <!-- COVER -->
  <div class="cover-wrapper" role="button" tabindex="0" title="Klik untuk ganti header" onclick="document.getElementById('headerUpload').click()">
    <img id="headerPreview" src="{{ $user->header ? asset('storage/'.$user->header) : 'https://via.placeholder.com/1400x380' }}" alt="Header">
    <button class="cover-edit-btn" aria-hidden="true"><i class="fa-solid fa-pen"></i></button>
    <input id="headerUpload" name="header" form="editProfileForm" type="file" accept="image/*" class="d-none">
  </div>

  <!-- PROFILE PHOTO -->
  <div class="profile-photo-outer">
    <div class="profile-photo" role="button" tabindex="0" onclick="document.getElementById('fotoUpload').click()">
      <img id="fotoPreview" src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://via.placeholder.com/150' }}" alt="Foto Profil">
      <button class="photo-edit-btn" aria-hidden="true"><i class="fa-solid fa-pen"></i></button>
      <input id="fotoUpload" name="foto" form="editProfileForm" type="file" accept="image/*" class="d-none">
    </div>
  </div>

  <!-- FORM CARD (glass) -->
  <section class="glass-card">
    <div class="card-body">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <h3 class="title">Edit Profile</h3>
        <button id="saveBtn" form="editProfileForm" type="submit" class="btn btn-save">
          <span class="label">Simpan Perubahan</span>
        </button>
      </div>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
      @endif

      <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input name="nama" class="form-control form-input" value="{{ $user->nama }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Username</label>
            <input id="usernameInput" name="username" class="form-control form-input" value="{{ $user->username }}">
            <div class="d-flex justify-content-between align-items-center mt-1">
              <small id="usernameStatus" class="text-muted small"></small>
              <small id="usernameSpinner" class="visually-hidden small"><i class="fa-solid fa-spinner fa-spin"></i></small>
            </div>
          </div>

          <div class="col-12">
            <label class="form-label">Bio</label>
            <textarea name="bio" rows="3" class="form-control form-input">{{ $user->bio }}</textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Ubah Password</label>
            <div class="password-wrapper">
              <input id="passwordField" name="password" type="password" class="form-control form-input" placeholder="Kosongkan jika tidak ingin mengubah">
              <button id="togglePassword" type="button" class="btn-icon" aria-label="Toggle password visibility"><i class="fa-solid fa-eye"></i></button>
            </div>
          </div>

          <div class="col-md-6 d-none">
            <!-- reserved for future (e.g. role or extra) -->
          </div>
        </div>
      </form>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/profile-edit.js') }}"></script>
@if(session('success'))
  <div id="toast-success" class="toast-float">
    {{ session('success') }}
  </div>
@endif

</body>
</html>
