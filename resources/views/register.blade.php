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

  <!-- Style Global -->
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />

  <!-- === REGISTER PAGE CSS === -->
  <style>
    .login-wrapper {
      display: flex;
      min-height: 50vh;
      background: #f8f9fd;
    }

    .login-form {
      flex: 1;
      padding: 10px 60px;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .illustration-right {
      flex: 1;
      background: #7b2cbf;
      display: flex;
      height: 500px;
      align-items: center;
      justify-content: center;
    }

    .illustration-right img {
      max-width: 80%;
    }

    .brand-name {
      font-weight: 700;
      color: #7b2cbf;
      font-size: 32px;
    }

    /* Password wrapper */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper .toggle-password {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      color: #7b2cbf;
      cursor: pointer;
    }

    .password-wrapper .toggle-password:hover {
      color: #5a189a;
    }

    /* Mobile */
    @media (max-width: 768px) {
      .login-wrapper {
        flex-direction: column;
      }

      .illustration-right {
        display: none;
      }

      .login-form {
        padding: 60px 30px;
      }
    }
  </style>
</head>

<body class="login-page soft-login">

<div class="login-wrapper">

  <!-- ===== FORM REGISTER ===== -->
  <div class="login-form">
    <h2 class="brand-name mb-2">Pagee</h2>
    <p class="text-muted mb-4">Buat akun dan mulai ceritamu ✨</p>

    <form id="registerForm" action="{{ route('register') }}" method="POST">
      @csrf

      <!-- NAMA -->
      <div class="mb-3 text-start">
        <label class="form-label">Nama Pengguna</label>
        <input
          type="text"
          name="nama"
          value="{{ old('nama') }}"
          class="form-control neumorphic @error('nama') is-invalid @enderror"
          placeholder="Masukkan username"
        >
        @error('nama')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- EMAIL -->
      <div class="mb-3 text-start">
        <label class="form-label">Email</label>
        <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          class="form-control neumorphic @error('email') is-invalid @enderror"
          placeholder="Masukkan email"
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- PASSWORD -->
      <div class="mb-3 text-start">
        <label class="form-label">Kata Sandi</label>
        <div class="password-wrapper">
          <input
            type="password"
            name="password"
            id="password"
            class="form-control neumorphic @error('password') is-invalid @enderror"
            placeholder="Buat kata sandi"
          >
          <button type="button" class="toggle-password" data-target="password">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>
        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-purple w-100 mt-3 py-2">
        Daftar Sekarang
      </button>
    </form>
    <p class="mt-3 text-center">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="">Masuk</a>
    </p>
  </div>

  <!-- ===== ILUSTRASI ===== -->
  <div class="illustration-right">
    <img src="{{ asset('assets/image/login3.png') }}" alt="Ilustrasi Daftar">
  </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- === PASSWORD TOGGLE SCRIPT === -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".toggle-password").forEach(btn => {
    btn.addEventListener("click", () => {
      const targetId = btn.dataset.target;
      const input = document.getElementById(targetId);
      const icon = btn.querySelector("i");

      if (!input) return;

      const isHidden = input.type === "password";
      input.type = isHidden ? "text" : "password";

      icon.classList.toggle("fa-eye", !isHidden);
      icon.classList.toggle("fa-eye-slash", isHidden);
    });
  });
});
</script>

</body>
</html>
