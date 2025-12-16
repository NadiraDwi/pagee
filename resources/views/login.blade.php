<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Pagee</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">


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

      <!-- Form Login -->
      <form id="loginForm" action="{{ route('login') }}" method="POST">
      @csrf

      {{-- EMAIL --}}
      <div class="mb-3 text-start">
          <label class="form-label">Email</label>
          <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control neumorphic @error('email') is-invalid @enderror"
              placeholder="Masukkan email kamu"
          >
          @error('email')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      {{-- PASSWORD --}}
      <div class="mb-3 text-start">
          <label class="form-label">Kata Sandi</label>
          <input
              type="password"
              name="password"
              class="form-control neumorphic @error('password') is-invalid @enderror"
              placeholder="Masukkan kata sandi"
          >
          @error('password')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="#" class="forgot">Lupa kata sandi?</a>
      </div>

      <button type="submit" class="btn btn-purple w-100 mt-2">
          Masuk
      </button>
      </form>

      <div class="mt-3 text-center">
        <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/script.js') }}"></script>
</body>
</html>
