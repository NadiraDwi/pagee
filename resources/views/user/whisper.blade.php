@extends('user.layouts')

@section('title', 'Whisper')
@section('nav-whisper', 'active')

@section('content')
<h3 class="mb-3">Whisper 🕊️</h3>


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

<div id="feedPosts">
    @foreach($posts as $post)
        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <!-- USER INFO (Anonymous) -->
                <div class="d-flex align-items-center mb-2">
                    <img src="https://i.pravatar.cc/45?img=0" class="rounded-circle me-2" width="45">
                    <div>
                        <strong>@Anonymous</strong><br>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- CONTENT -->
                <p>{{ $post->isi }}</p>

                <!-- ACTION BUTTONS -->
                <div class="d-flex gap-4 action-wrapper">
                    <button class="action-btn" onclick="toggleComment(this)">
                        <i class="fa-regular fa-comment"></i>
                    </button>

                    <button class="action-btn toggle-love-btn" data-post-id="{{ $post->id_post }}">
                        <i class="{{ $post->likedBy(auth()->id()) ? 'fa-solid text-danger' : 'fa-regular' }} fa-heart"></i>
                    </button>

                    <span class="like-count">{{ $post->likes->count() }} likes</span>

                    <button class="action-btn" onclick="sharePost()">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>

                <!-- COMMENT BOX -->
                <div class="comment-box mt-2 d-none d-flex gap-2">
                    <input type="text"
                           class="form-control comment-input"
                           data-post-id="{{ $post->id_post }}"
                           placeholder="Tulis komentar...">

                    <button class="btn btn-purple btn-sm send-comment-btn"
                            data-post-id="{{ $post->id_post }}">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>

                <!-- COMMENTS LIST -->
                <div class="comments-list mt-2">
                    @foreach($post->comments as $comment)
                        <div class="d-flex mb-2">
                            <strong>{{ $comment->user->nama }}:</strong>
                            <span class="ms-1">{{ $comment->isi_komentar }}</span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<!-- Bisa langsung pakai script like/comment dari feed utama -->
@endpush
