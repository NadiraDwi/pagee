<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Pagee</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

  <!-- Style Global -->
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
</head>
<body class="login-page soft-login">

  <div class="login-wrapper">
    <!-- Gambar sisi kiri -->
    <div class="login-illustration">
      <img src="{{ asset('assets/image/login3.png') }}" alt="Ilustrasi Login">
    </div>

    <!-- Form sisi kanan -->
    <div class="login-form">
      <h2 class="brand-name">Pagee</h2>
      <p class="welcome-text">Selamat datang kembali ✨</p>

      <form id="loginForm">
        <div class="mb-3 text-start">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control neumorphic" id="email" placeholder="Masukkan email kamu" required>
        </div>

        <div class="mb-3 text-start">
          <label for="password" class="form-label">Kata Sandi</label>
          <input type="password" class="form-control neumorphic" id="password" placeholder="Masukkan kata sandi" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="#" class="forgot">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn btn-purple w-100 mt-2">Masuk</button>
      </form>

      <div class="mt-3 text-center">
        <small>Belum punya akun? <a href="register.html">Daftar di sini</a></small>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/script.js') }}"></script>
</body>
</html>
