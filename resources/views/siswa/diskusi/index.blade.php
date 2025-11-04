{{-- File: index.blade.php --}}
@extends('layout_siswa.app')

@section('konten')
<div class="container mt-5">
    {{-- Judul Halaman dan Tombol --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold mb-0">💬 Forum Diskusi</h1>
        <a href="{{ route('threads.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Buat Diskusi
        </a>
    </div>
    <hr class="mb-4">

    {{-- Daftar Thread --}}
    @forelse($threads as $thread)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title mb-2">
                    <a href="{{ route('threads.show', $thread->id) }}" class="text-decoration-none">{{ $thread->title }}</a>
                </h5>
                <p class="card-text text-muted">{{ Str::limit($thread->content, 150) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        <i class="fa-solid fa-user me-1"></i>
                        Dibuat oleh: <strong>{{ $thread->user->name ?? 'Pengguna Tidak Dikenal' }}</strong>
                    </small>
                    <small class="text-muted">
                        <i class="fa-solid fa-clock me-1"></i>
                        {{ $thread->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada diskusi yang dibuat. Jadilah yang pertama!
        </div>
    @endforelse

    {{-- Pagination Links --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $threads->links() }}
    </div>
</div>
@endsection