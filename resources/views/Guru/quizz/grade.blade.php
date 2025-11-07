@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="row">
        {{-- Kolom Kiri: Informasi dan File Jawaban --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Penilaian Kuis: {{ $submission->quiz->judul }}</h4>
                </div>
                <div class="card-body">
                    <h5>Siswa: <strong>{{ $submission->user->username }}</strong></h5>
                    <p class="text-muted">Waktu Mengumpulkan: {{ $submission->created_at->format('d M Y, H:i') }}</p>
                    <hr>
                    <h5 class="font-weight-bold">File Jawaban Pelajar</h5>
                    <a href="{{ asset('storage/' . $submission->file_path) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-download"></i> Unduh / Lihat Jawaban
                    </a>
                    
                    {{-- Tampilkan preview jika file adalah gambar --}}
                    @if(in_array(pathinfo($submission->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $submission->file_path) }}" class="img-fluid img-thumbnail" alt="Jawaban Gambar">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Penilaian --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Berikan Nilai</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('guru.quiz.storeGrade', $submission->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nilai">Nilai (0-100)</label>
                            <input type="number" class="form-control" name="nilai" id="nilai" min="0" max="100" step="0.01" value="{{ $submission->nilai }}" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Simpan Nilai</button>
                    </form>
                </div>
            </div>
             <a href="{{ route('guru.quiz.show', $submission->quiz_id) }}" class="btn btn-secondary mt-3 w-100">Kembali</a>
        </div>
    </div>
</div>
@endsection