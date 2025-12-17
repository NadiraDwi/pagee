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

  <!-- === LOGIN PAGE CSS === -->
  <style>
    /* Wrapper */
    .login-wrapper {
      display: flex;
      min-height: 100vh;
      background: #f8f9fd;
    }

    .login-illustration {
      flex: 1;
      background: #7b2cbf;
      display: flex;
      height: 400px;
      align-items: center;
      justify-content: center;
    }

    .login-illustration img {
      max-width: 80%;
    }

    .login-form {
      flex: 1;
      padding: 10px 60px;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand-name {
      font-weight: 700;
      color: #7b2cbf;
      font-size: 32px;
      margin-bottom: 5px;
    }

    .welcome-text {
      color: #666;
      margin-bottom: 30px;
    }

    /* Password toggle */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper .toggle-password {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      border: none;
      background: transparent;
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

      .login-illustration {
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

    <!-- ===== ILUSTRASI ===== -->
    <div class="login-illustration">
      <img src="{{ asset('assets/image/login3.png') }}" alt="Ilustrasi Login">
    </div>

    <!-- ===== FORM LOGIN ===== -->
    <div class="login-form">
      <h2 class="brand-name">Pagee</h2>
      <p class="welcome-text">Selamat datang kembali ✨</p>

      <form id="loginForm" action="{{ route('login') }}" method="POST">
        @csrf

        <!-- EMAIL -->
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

        <!-- PASSWORD -->
        <div class="mb-3 text-start">
          <label class="form-label">Kata Sandi</label>

          <div class="password-wrapper">
            <input
              type="password"
              name="password"
              id="passwordInput"
              class="form-control neumorphic @error('password') is-invalid @enderror"
              placeholder="Masukkan kata sandi"
            >

            <button type="button" class="toggle-password" tabindex="-1">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>

          @error('password')
            <div class="invalid-feedback d-block">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-purple w-100 mt-2">
          Masuk
        </button>
      </form>

      <div class="mt-3 text-center">
        <small>Belum punya akun?
          <a href="{{ route('register') }}">Daftar di sini</a>
        </small>
      </div>
    </div>

  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/script.js') }}"></script>

  <!-- === PASSWORD TOGGLE SCRIPT === -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const toggleBtn = document.querySelector(".toggle-password");
      const passwordInput = document.getElementById("passwordInput");

      if (!toggleBtn || !passwordInput) return;

      toggleBtn.addEventListener("click", () => {
        const isHidden = passwordInput.type === "password";
        passwordInput.type = isHidden ? "text" : "password";

        const icon = toggleBtn.querySelector("i");
        icon.classList.toggle("fa-eye", !isHidden);
        icon.classList.toggle("fa-eye-slash", isHidden);
      });
    });
  </script>

</body>
</html>
