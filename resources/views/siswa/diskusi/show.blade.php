@extends('layout2.app')

@section('konten')
<div class="container mt-2">
    <!-- Judul Thread -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $thread->title }}</h3>
            <small>Dibuat oleh: <strong>{{ $thread->user->username }}</strong> | {{ $thread->created_at->diffForHumans() }}</small>
        </div>
        <div class="card-body">
            <p class="text-dark">{{ $thread->content }}</p>
        </div>
    </div>

    <!-- Komentar -->
    <h4 class="mt-4">Komentar</h4>
    @forelse($thread->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p class="mb-1">{{ $comment->content }}</p>
                <small class="text-muted">Dibuat oleh: <strong>{{ $comment->user->role }}</strong> <strong>{{ $comment->user->username }}</strong> | {{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
    @endforelse

    <!-- Form Komentar -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5>Tulis Komentar</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('comments.store', $thread->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection
