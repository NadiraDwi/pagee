<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar | Pagee</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
</head>

<body class="login-page soft-login">

  <div class="login-wrapper">
    <!-- Form sisi kiri -->
    <div class="login-form">
      <h2 class="brand-name mb-2">Pagee</h2>
      <form id="registerForm" class="text-start" action="{{ route('register') }}" method="POST">
      @csrf
        <div class="mb-3">
          <label for="username" class="form-label fw-semibold">Nama Pengguna</label>
          <input type="text" class="form-control neumorphic" id="username" name="nama" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label fw-semibold">Email</label>
          <input type="email" class="form-control neumorphic" id="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-semibold">Kata Sandi</label>
          <input type="password" class="form-control neumorphic" id="password" name="password" placeholder="Buat kata sandi" required>
        </div>

        <button type="submit" class="btn btn-purple w-100 mt-3 py-2 fw-semibold">Daftar Sekarang</button>
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
