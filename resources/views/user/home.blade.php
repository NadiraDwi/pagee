@extends('user.layouts')

@section('title', 'Beranda')
@section('nav-home', 'active')

@section('content')

<!-- Floating Button (TETAP DI HALAMAN INI, BUKAN LAYOUT) -->
<button class="floating-btn" id="postTypeTrigger">
    <i class="fa-solid fa-plus"></i>
</button>

<!-- ===== Modal Pilih Jenis Post ===== -->
<div class="modal fade" id="postTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">

            <div class="modal-header">
                <h5 class="modal-title">Pilih Jenis Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-3">Mau membuat post pendek atau panjang?</p>

                <button class="btn btn-purple w-100 mb-2"
                    id="shortPostBtn"
                    data-url="{{ route('post-short-create') }}">
                    Short Post
                </button>

                <button class="btn btn-purple w-100"
                    id="longPostBtn"
                    data-url="{{ route('post-long-create') }}">
                    Long Post
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ===== FEED POST ===== -->
<div id="feedPosts">

    @foreach($posts as $post)
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-2">

                    @if(!$post->is_anonymous)
                        <a href="{{ route('user.profile', $post->user->id_user) }}"
                           class="d-flex align-items-center text-decoration-none text-dark">
                            <img src="{{ $post->user->pp ?? 'https://i.pravatar.cc/45' }}"
                                 class="rounded-circle me-2" width="45">
                            <div>
                                <strong>{{ $post->user->nama }}</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @else
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/45?img=0"
                                 class="rounded-circle me-2" width="45">
                            <div>
                                <strong>@Anonymous</strong><br>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- JUDUL KHUSUS LONG POST -->
                @if($post->jenis_post === 'long')
                    <h5 class="fw-bold mb-2">{{ $post->judul }}</h5>
                @endif

                <!-- ISI POST -->
                <p>{{ $post->isi }}</p>

                <!-- ACTIONS -->
                <div class="d-flex gap-4">
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-regular fa-comment"></i>
                    </button>
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <button class="btn btn-link p-0 text-muted">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>

            </div>
        </div>
    @endforeach

</div>

@endsection


@section('rightbar')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="fw-bold text-purple">
                <i class="fa-solid fa-music me-2"></i>Musik Populer
            </h5>
            <ul class="list-unstyled small mt-2">
                <li>Daylight - David Kushner</li>
                <li>Blue - Keshi</li>
                <li>Runaway - AURORA</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold text-purple">
                <i class="fa-solid fa-fire me-2"></i>Tren Whisper
            </h5>
            <ul class="list-unstyled small mt-2">
                @foreach($trends as $trend)
                    <li>{{ $trend }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    // === Floating Button Handler ===
    document.getElementById("postTypeTrigger").addEventListener("click", function () {
        if (!isLoggedIn) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        new bootstrap.Modal(document.getElementById("postTypeModal")).show();
    });

    // === Short Post Redirect ===
    document.getElementById("shortPostBtn").addEventListener("click", function () {
        window.location.href = this.dataset.url;
    });

    // === Long Post Redirect ===
    document.getElementById("longPostBtn").addEventListener("click", function () {
        window.location.href = this.dataset.url;
    });
</script>
@endpush
