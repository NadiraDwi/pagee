@extends('user.layouts')

@section('content')
<div class="container">

    <div class="text-center mb-4">
        <img src="{{ $user->pp ?? 'https://i.pravatar.cc/120' }}" 
             class="rounded-circle mb-2" width="120">
        <h3 class="fw-bold">@{{ $user->nama }}</h3>
    </div>

    <h5 class="fw-bold mb-3">Postingan {{ $user->nama }}</h5>

    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            @if($post->jenis_post === 'long')
                <h5 class="fw-bold">{{ $post->judul }}</h5>
            @endif
            <p>{{ $post->isi }}</p>
        </div>
    </div>
    @endforeach

</div>
@endsection
