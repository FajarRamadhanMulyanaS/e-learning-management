{{-- File: show.blade.php --}}
@extends('layout2.app')

@section('konten')
<div class="container my-4">
    {{-- Konten Thread Utama --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $thread->title }}</h3>
        </div>
        <div class="card-body">
            <p class="card-text fs-5">{{ $thread->content }}</p>
            <hr>
            <div class="d-flex justify-content-end text-muted">
                <small class="me-3">
                    <i class="fa-solid fa-user me-1"></i>
                    Dibuat oleh: <strong>{{ $thread->user->username }}</strong>
                </small>
                <small>
                    <i class="fa-solid fa-clock me-1"></i>
                    {{ $thread->created_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>

    {{-- Judul Bagian Komentar --}}
    <h4 class="mb-3">Komentar ({{ $thread->comments->count() }})</h4>

    {{-- Daftar Komentar --}}
    @forelse($thread->comments as $comment)
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div class="fw-bold">
                    <i class="fa-solid fa-user-circle me-2"></i>
                    {{ $comment->user->username }} 
                    <span class="badge bg-secondary">{{ $comment->user->role }}</span>
                </div>
                <small class="text-muted">
                    <i class="fa-solid fa-clock me-1"></i>
                    {{ $comment->created_at->diffForHumans() }}
                </small>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $comment->content }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted fst-italic">Belum ada komentar. Jadilah yang pertama!</p>
    @endforelse

    {{-- Form untuk Menulis Komentar Baru --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0">Tinggalkan Komentar</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('comments.store', $thread->id) }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <textarea name="content" class="form-control" rows="4" placeholder="Tulis komentar Anda di sini..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane me-2"></i>Kirim
                </button>
            </form>
        </div>
    </div>
</div>
@endsection