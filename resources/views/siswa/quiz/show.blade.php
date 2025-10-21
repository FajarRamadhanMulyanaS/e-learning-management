@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            {{-- Bagian Header Detail Kuis --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $quiz->judul }}</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Mata Pelajaran: {{ $quiz->guruMapel->mapel->nama_mapel }} | Guru: {{ $quiz->guruMapel->user->username }}
                    </p>
                    <hr>
                    <h5 class="font-weight-bold">Deskripsi / Petunjuk Pengerjaan</h5>
                    <p>{!! nl2br(e($quiz->description)) !!}</p>
                </div>
            </div>

            {{-- Bagian Lampiran dari Guru --}}
            @if($quiz->attachment_file || $quiz->attachment_link || $quiz->attachment_image)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Materi Lampiran dari Guru</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @if($quiz->attachment_file)
                            <li><strong>File:</strong> <a href="{{ asset('storage/' . $quiz->attachment_file) }}" target="_blank">Unduh/Lihat File</a></li>
                        @endif
                        @if($quiz->attachment_link)
                            <li><strong>Link:</strong> <a href="{{ $quiz->attachment_link }}" target="_blank">{{ $quiz->attachment_link }}</a></li>
                        @endif
                    </ul>
                    @if($quiz->attachment_image)
                        <hr>
                        <strong>Gambar:</strong><br>
                        <img src="{{ asset('storage/' . $quiz->attachment_image) }}" alt="Gambar Lampiran" class="img-fluid img-thumbnail mt-2" style="max-width: 400px;">
                    @endif
                </div>
            </div>
            @endif

            {{-- Bagian Pengumpulan Jawaban --}}
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Kumpulkan Jawaban Anda</h4>
                </div>
                <div class="card-body">
                    {{-- Form ini akan kita fungsikan selanjutnya untuk mengirim jawaban --}}
                    <form action="{{ route('siswa.quiz.submit', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p>Silakan kerjakan kuis sesuai petunjuk, lalu upload file jawaban Anda di sini.</p>
                        
                        <div class="form-group">
                            <label for="submission_file" class="font-weight-bold">Lampirkan File Jawaban</label>
                            <input type="file" class="form-control-file" id="submission_file" name="submission_file" required>
                            <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX, JPG, PNG.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg mt-3">Kumpulkan Jawaban</button>
                    </form>
                </div>
            </div>

            <a href="{{ route('siswa.quiz.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kuis</a>
        </div>
    </div>
</div>
@endsection