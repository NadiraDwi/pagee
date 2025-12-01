@if ($whispers->isEmpty())
    <div class="mt-4">
        <p class="text-muted">Belum ada whisper.</p>
    </div>
@else
    @foreach ($whispers as $w)
        <div class="whisper-note p-3 mt-3 rounded">
            <p class="note-text mb-1">{{ $w->isi }}</p>
            <span class="note-time small">{{ $w->created_at->diffForHumans() }}</span>
        </div>
    @endforeach
@endif
