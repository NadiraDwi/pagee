@extends('admin.layouts')

@section('title', 'Setting Akun')

@section('content')

<style>
.btn-purple {
    background-color: #6f42c1;
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 6px;
    transition: 0.2s;
}
.btn-purple:hover {
    background-color: #5931a3;
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

<div class="mb-3">
    <h2 class="mb-0">Setting Akun</h2>
</div>

@php
    $user = auth()->user();
@endphp

<div class="row">
    <!-- CARD KIRI : DATA AKUN -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header fw-semibold">
                Data Akun
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama"
                               value="{{ old('nama', $user->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username"
                               value="{{ old('username', $user->username) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea class="form-control" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-purple">
                        Simpan Data Akun
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- CARD KANAN : UBAH PASSWORD -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header fw-semibold">
                Ubah Password
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-muted">Minimal 8 karakter</small>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                        @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-purple">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
