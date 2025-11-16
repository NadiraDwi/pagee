<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagee | Beranda</title>
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
        <li><a href="#" class="sidebar-link active"><i class="fa-solid fa-house me-2"></i>Beranda</a></li>
        <li><a href="#" class="sidebar-link"><i class="fa-regular fa-comment-dots me-2"></i>Whisper</a></li>
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

      <div class="d-flex align-items-center">
        <button id="modeToggle" class="btn btn-link text-dark fs-4 p-0" title="Ubah tema">
          <i class="fa-solid fa-moon"></i>
        </button>

        <a href="{{ route('profile.show') }}" class="btn btn-link text-dark fs-4 p-0 ms-2" title="Profil">
          <i class="fa-solid fa-user profile-icon"></i>
        </a>
      </div>

      </a>
    </div>
  </nav>

  <!-- ===== MAIN LAYOUT ===== -->
  <div class="main-layout">
    <main class="content">
      <!-- Short Post Placeholder -->
      <div class="card shadow-sm mb-3" id="shortPostPlaceholder">
        <div class="card-body">
          <textarea class="form-control border-0 mb-3" rows="1" placeholder="Apa yang ingin kamu bagikan hari ini?" readonly></textarea>
        </div>
      </div>


      <!-- Modal Pilih Jenis Post -->
      <div class="modal fade" id="postTypeModal" tabindex="-1" aria-labelledby="postTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0">
            <div class="modal-header">
            <h5 class="modal-title" id="postTypeModalLabel">Pilih Jenis Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
            <p class="mb-3">Mau membuat post pendek atau panjang?</p>

            <button class="btn btn-purple me-2" id="shortPostBtn">Short Post</button>
            <br></br>
            <button class="btn btn-purple me-2" id="longPostBtn" data-url="{{ route('post-long-create') }}">Long Post</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Form short post (hidden awalnya) -->
      <div class="card shadow-sm mb-3" id="shortPostForm" style="display:none;">
        <div class="card-body">
          <form id="shortPostFormAjax" action="{{ route('posts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis_post" value="short">
            <textarea name="isi" class="form-control border-0 mb-3" rows="3" placeholder="Apa yang ingin kamu bagikan?" required></textarea>
            <div class="text-end">
              <button type="submit" class="btn btn-purple">Posting</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Feed Posts -->
      <div id="feedPosts">
      @foreach($posts as $post)
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <img src="https://randomuser.me/api/portraits/men/1.jpg" class="rounded-circle me-2" width="45" height="45" alt="">
            <div>
              <strong>{{ '@'.$post->user->nama }}</strong><br>
              <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>
          </div>
          <p>{{ $post->isi }}</p>
          <div class="d-flex gap-4">
            <button class="btn btn-link p-0 text-muted"><i class="fa-regular fa-comment"></i></button>
            <button class="btn btn-link p-0 text-muted"><i class="fa-regular fa-heart"></i></button>
            <button class="btn btn-link p-0 text-muted"><i class="fa-solid fa-share-nodes"></i></button>
          </div>
        </div>
      </div>
      @endforeach
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
