<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar | Pagee</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
</head>

<body class="login-page soft-login">

  <div class="login-wrapper">
    <!-- Form sisi kiri -->
    <div class="login-form">
      <h2 class="brand-name mb-2">Pagee</h2>
      <form id="registerForm" class="text-start" action="{{ route('register') }}" method="POST">
      @csrf

      {{-- NAMA --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Nama Pengguna</label>
          <input
              type="text"
              name="nama"
              value="{{ old('nama') }}"
              class="form-control neumorphic @error('nama') is-invalid @enderror"
              placeholder="Masukkan username"
          >
          @error('nama')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      {{-- EMAIL --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input
              type="text"
              name="email"
              value="{{ old('email') }}"
              class="form-control neumorphic @error('email') is-invalid @enderror"
              placeholder="Masukkan email"
          >
          @error('email')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      {{-- PASSWORD --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Kata Sandi</label>
          <input
              type="password"
              name="password"
              class="form-control neumorphic @error('password') is-invalid @enderror"
              placeholder="Buat kata sandi"
          >
          @error('password')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>

      <button type="submit" class="btn btn-purple w-100 mt-3 py-2 fw-semibold">
          Daftar Sekarang
      </button>
      </form>


      <p class="mt-3 text-center">
        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk</a>
      </p>
    </div>

    <!-- Ilustrasi sisi kanan -->
    <div class="illustration-right">
      <img src="{{ asset('assets/image/login3.png') }}" alt="Ilustrasi Daftar">
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
