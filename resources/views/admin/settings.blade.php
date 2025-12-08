@extends('admin.layouts')

@section('title', 'Setting Akun')

@section('content')

<style>
.btn-purple {
    background-color: #6f42c1;  /* Ungu */
    color: #fff;                 /* Teks putih */
    border: none;                /* Hilangkan border default */
    padding: 8px 18px;
    border-radius: 6px;
    transition: 0.2s;
}
.btn-purple:hover {
    background-color: #5931a3;  /* Ungu lebih gelap saat hover */
    color: #fff;
}
</style>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Akun</li>
                    <li class="breadcrumb-item">Setting Akun</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">Setting Akun</h2>
</div>

<div class="card">
    <div class="card-body">
        @php
            $user = auth()->user();
        @endphp

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="{{ old('username', $user->username) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" name="bio" id="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <input type="password" class="form-control" name="password" id="password">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
            </div>

            <button type="submit" class="btn btn-purple">Simpan Perubahan</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Preview foto sebelum upload
    document.getElementById('foto')?.addEventListener('change', function(e){
        const reader = new FileReader();
        reader.onload = function(event){
            const imgPreview = document.querySelector('img[alt="Foto Profil"]');
            if(imgPreview){
                imgPreview.src = event.target.result;
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endpush
