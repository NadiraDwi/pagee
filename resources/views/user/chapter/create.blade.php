@extends('user.layouts')

@section('title', 'Tambah Chapter')

@section('content')

{{-- TRIX EDITOR --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

<style>

/* Card Tengah */
.form-wrapper {
    max-width: 780px;
    margin: auto;
}

/* Button Outline Ungu */
.btn-outline-purple {
    border: 1.8px solid #6f42c1;
    color: #6f42c1;
    padding: 5px 14px;
    font-size: 14px;
    border-radius: 8px;
    background: transparent;
    transition: 0.2s ease;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-outline-purple:hover {
    background: #6f42c1;
    color: #fff;
}

/* Button Ungu */
.btn-purple {
    background: #6f42c1;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    width: 100%;
    font-weight: 600;
    transition: .2s;
}

.btn-purple:hover {
    background: #5933a5;
}

/* TRIX EDITOR FIX */
trix-editor {
    min-height: 180px;
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 10px;
}

</style>


<h4 class="fw-bold mb-3">Tambah Chapter Baru</h4>

<a href="{{ route('chapter.show', $post->id_post) }}" class="btn-outline-purple mb-3">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>

<div class="card shadow-sm form-wrapper">
    <div class="card-body">

        <form action="{{ route('chapter.store', $post->id_post) }}" method="POST">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-3">
                <label class="fw-semibold">Judul Chapter</label>
                <input type="text" name="judul_chapter" class="form-control"
                       placeholder="Masukkan judul chapter..." required>
            </div>

            {{-- ISI CHAPTER (TRIX) --}}
            <div class="mb-3">
                <label class="fw-semibold">Isi Chapter</label>
                <input id="isi_chapter" type="hidden" name="isi_chapter">
                <trix-editor input="isi_chapter"></trix-editor>
            </div>

            {{-- LINK MUSIK --}}
            <div class="mb-3">
                <label class="fw-semibold">Link Musik (Opsional)</label>
                <input type="text" name="link_musik" class="form-control"
                       placeholder="Contoh: https://youtu.be/xxxx">
            </div>

            <button type="submit" class="btn-purple mt-2">Simpan Chapter</button>

        </form>

    </div>
</div>

@endsection
