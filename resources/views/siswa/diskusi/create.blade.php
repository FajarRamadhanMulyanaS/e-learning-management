@extends('layout2.app')

@section('konten')
<div class="container">
    <h1>Buat Thread Baru</h1>

    {{-- PERUBAHAN 1: Tambahkan enctype untuk upload file --}}
    <form action="{{ route('threads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Isi</label>
            <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- PERUBAHAN 2: Tambahkan input untuk lampiran file --}}
        <div class="mb-3">
            <label for="attachments" class="form-label">Lampiran (Opsional)</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
            <small class="form-text text-muted">Anda dapat melampirkan beberapa file sekaligus.</small>
        </div>

        <button type="submit" class="btn btn-success">Posting</button>
    </form>
</div>
@endsection