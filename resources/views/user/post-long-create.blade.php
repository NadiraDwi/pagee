<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagee | Long Post</title>
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
      <!-- Form Long Post -->
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="mb-3">Tulis Long Post</h5>
          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_post" value="long">

            <div class="mb-3">
                <input type="text" name="judul" class="form-control" placeholder="Judul Post" required>
            </div>

            <div class="mb-3">
                <textarea class="form-control" name="isi" rows="10" placeholder="Tulis ceritamu..." required></textarea>
            </div>

            <!-- ========== UPLOAD COVER ========== -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Cover Post (opsional)</label>
                <input type="file" name="cover" id="coverInput" class="form-control" accept="image/*">

                <!-- Preview -->
                <div class="mt-3">
                    <img id="coverPreview" src="#" alt="Preview Cover" 
                        style="display:none; max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>
            <!-- ================================== -->

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

  <script>
  document.getElementById('coverInput').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('coverPreview');

      if (file) {
          const reader = new FileReader();

          reader.onload = function(e) {
              preview.src = e.target.result;
              preview.style.display = 'block';
          }

          reader.readAsDataURL(file);
      } else {
          preview.style.display = 'none';
          preview.src = "#";
      }
  });
  </script>

</body>
</html>
