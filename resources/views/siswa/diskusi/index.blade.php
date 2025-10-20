@extends('layout2.app')

@section('konten')
<div class="container mt-5">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">💬 Forum Diskusi</h1>
        <!-- Tombol Buat Diskusi -->
        <a href="{{ route('threads.create') }}" class="btn btn-primary btn-lg shadow">
            <i class="fa-solid fa-plus"></i> Buat Diskusi
        </a>
    </div>
    <hr>

@foreach($threads as $thread)
<div class="card mb-3">
    <div class="card-body">
        <h5><a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a></h5>
        <p>{{ Str::limit($thread->content, 100) }}</p>
        <small>Dibuat oleh: {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}</small>
    </div>
</div>
</div>
@endforeach

{{ $threads->links() }}
@endsection
