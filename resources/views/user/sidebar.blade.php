<style>
    .toggle-love-btn, .action-btn {
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2rem;
        color: #6c6c6c; /* default abu */
        transition: 0.2s;
    }
    .toggle-love-btn:hover {
        transform: scale(1.15);
        color: #9b59ff;
    }
    .toggle-love-btn .fa-solid.text-danger {
        color: #e63946 !important; /* merah saat liked */
    }
    .text-purple {
        color: #7a39f8;
    }
</style>

{{-- RIGHT SIDEBAR --}}
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