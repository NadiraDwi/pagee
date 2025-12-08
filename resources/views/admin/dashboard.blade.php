@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

<h1 class="hero">Halo Admin Pagee!</h1>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3 card-custom">
            <small class="text-muted">Total Users</small>
            <h3>{{ number_format($totalUsers) }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 card-custom">
            <small class="text-muted">Total Pages</small>
            <h3>{{ number_format($totalPages) }}</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 card-custom">
            <small class="text-muted">Active Admins</small>
            <h3>{{ number_format($activeAdmins) }}</h3>
        </div>
    </div>
</div>

@endsection
