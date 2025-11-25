@extends('user.layouts')

@section('title', 'Long Post')

@section('content')

<div class="card shadow-sm mb-3">
  <div class="card-body">

    <h5 class="mb-3">Tulis Long Post</h5>

    <form action="{{ route('posts.store.long') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="jenis_post" value="long">

      {{-- JUDUL --}}
      <div class="mb-3">
          <input type="text" name="judul" class="form-control" placeholder="Judul Post" required>
      </div>

      {{-- ISI --}}
      <div class="mb-3">
          <textarea class="form-control" name="isi" rows="10" placeholder="Deskripsi Post" required></textarea>
      </div>

      {{-- COVER --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Cover Post (opsional)</label>
          <input type="file" name="cover" id="coverInput" class="form-control" accept="image/*">

          <div class="mt-3">
              <img id="coverPreview" src="#" alt="Preview Cover"
                   style="display:none; max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
          </div>
      </div>

      <div class="text-end">
          <button type="submit" class="btn btn-purple">Posting</button>
      </div>

    </form>
  </div>
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
@endpush
