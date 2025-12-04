<link rel="stylesheet" href="{{ asset('assets/whisper.css') }}">
@if ($whispers->isEmpty())
    <div class="mt-4 text-center">
        <p class="text-muted fst-italic">Belum ada whisper ✨</p>
    </div>
@else
    <div class="whisper-grid">
        @foreach ($whispers as $w)
            <div class="whisper-card">
                <p class="note-text">{{ $w->isi }}</p>

                <span class="note-time">{{ $w->created_at->diffForHumans() }}</span>

                <!-- Label Anonymous otomatis -->
                <span class="anon-label">— Anonymous</span>
            </div>
        @endforeach
    </div>

@endif