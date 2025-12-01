@forelse($chapters as $post)
    <div class="post-card mb-3 p-3 rounded shadow-sm">

        {{-- COVER (jika ada) --}}
        @if ($post->cover)
            <img 
                src="{{ asset('storage/' . $post->cover->cover_path) }}"
                class="w-100 mb-3 rounded"
                style="max-height: 250px; object-fit: cover;"
            >
        @endif

        {{-- JUDUL --}}
        <h5 class="fw-bold" style="color: #6a4c93 !important;">{{ $post->judul }}</h5>

        {{-- ISI PREVIEW --}}
        <p class="text-muted">
            {{ \Illuminate\Support\Str::limit($post->isi, 150) }}
        </p>

    </div>
@empty
    <p class="text-muted mt-3">Belum ada chapter.</p>
@endforelse
