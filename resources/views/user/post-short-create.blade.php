<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagee | Short Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>

<body>

  <!-- ===== SIDEBAR KIRI ===== -->
  <aside class="sidebar-left">
    <div class="sidebar-top">
      <h3 class="brand fw-bold text-purple fs-4 mb-4">Pagee<span class="dot">.</span></h3>
      <ul class="list-unstyled mb-3">
        <li><a href="{{ route('home') }}" class="sidebar-link"><i class="fa-solid fa-house me-2"></i>Beranda</a></li>
        <li><a href="#" class="sidebar-link active"><i class="fa-regular fa-comment-dots me-2"></i>Whisper</a></li>
        <li><a href="#" class="sidebar-link"><i class="fa-solid fa-book-open me-2"></i>Chapter</a></li>
      </ul>
    </div>
    <div class="sidebar-bottom">
        <hr class="sidebar-divider">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-purple w-100 mt-2">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Logout
            </button>
        </form>
    </div>
  </aside>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-light bg-white shadow-sm fixed-top navbar-shift px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <form class="d-flex align-items-center search-bar">
        <span class="input-group-text border-0 bg-transparent pe-2"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
        <input class="form-control border-0 shadow-none" type="search" placeholder="Cari di Pagee..." aria-label="Search">
      </form>

      <button id="modeToggle" class="btn btn-link text-dark fs-4 p-0" title="Ubah tema">
        <i class="fa-solid fa-moon"></i>
      </button>
    </div>
  </nav>

  <!-- ===== MAIN LAYOUT ===== -->
  <div class="main-layout">
    <main class="content">

      <!-- === Card Short Post === -->
        <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-3">Tulis Short Post</h5>

            <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis_post" value="short">

            <!-- TEXTAREA -->
            <div class="mb-2 position-relative">
                <textarea id="inputPost" class="form-control" name="isi" rows="4"
                maxlength="150" placeholder="Tulis sesuatu..." required></textarea>

                <!-- Mention dropdown -->
                <ul id="mentionList" class="list-group position-absolute w-100 d-none" 
                    style="top: 105%; z-index: 10; max-height:150px; overflow-y:auto;">
                @foreach($users as $u)
                    <li class="list-group-item list-group-item-action mention-item"
                        data-username="{{ $u->username }}">
                        {{ $u->username }}
                    </li>
                @endforeach
                </ul>
            </div>

            <!-- CHARACTER COUNTER -->
            <p class="text-end small text-muted">
                <span id="charCount">0</span>/150 karakter
            </p>

            <!-- ADD PEOPLE (chip styling) -->
            <div class="mb-3">
            <button type="button" id="addPeopleBtn" class="btn btn-outline-purple">
                <i class="fa-solid fa-user-plus me-1"></i> Add People
            </button>

            <!-- BOX: daftar user -->
            <div id="peopleBox" class="card mt-2 d-none">
                <div class="card-body p-2">
                    <input type="text" id="peopleSearch" class="form-control form-control-sm mb-2"
                        placeholder="Cari user...">

                    <ul class="list-group small" id="peopleList" style="max-height:150px; overflow-y:auto;">
                        @foreach($users as $u)
                            <li class="list-group-item list-group-item-action user-item"
                                data-id="{{ $u->id_user }}">
                                {{ $u->nama }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Input hidden untuk menyimpan ID user yang dipilih -->
            <input type="hidden" name="mentions" id="mentionsInput">
            </div>


            <!-- ANONYMOUS TOGGLE -->
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" role="switch"
                    id="anonToggle" name="is_anonymous" value="1">
                <label class="form-check-label" for="anonToggle">
                Posting sebagai anonim
                </label>
            </div>

            <!-- SCHEDULE POST -->
            <div class="mb-3">
                <label class="fw-bold mb-1">Jadwalkan posting (opsional)</label>
                <input type="datetime-local" name="scheduled_at" class="form-control">
                <small class="text-muted">Jika tidak diisi, posting langsung dipublikasi.</small>
            </div>

            <!-- SUBMIT -->
            <div class="text-end">
                <button type="submit" class="btn btn-purple">Posting</button>
            </div>
            </form>
        </div>
        </div>


    </main>

    <!-- ===== SIDEBAR KANAN ===== -->
    <aside class="sidebar-right">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="fw-bold text-purple"><i class="fa-solid fa-music me-2"></i>Musik Populer</h5>
          <ul class="list-unstyled small mt-2">
            <li>“Daylight” - David Kushner</li>
            <li>“Blue” - Keshi</li>
            <li>“Runaway” - AURORA</li>
          </ul>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="fw-bold text-purple"><i class="fa-solid fa-fire me-2"></i>Tren Whisper</h5>
          <ul class="list-unstyled small mt-2">
            @foreach($trends as $trend)
              <li>{{ $trend }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </aside>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/script.js') }}"></script>
</body>
</html>
