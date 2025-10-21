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

            {{-- Bagian Status & Nilai Anda --}}
            @if($quiz->mySubmission)
                <div class="card shadow-sm mb-4">
                    <div class="card-header @if($quiz->mySubmission->nilai !== null) bg-success @else bg-info @endif text-white">
                        <h4 class="mb-0">Status & Nilai Anda</h4>
                    </div>
                    <div class="card-body">
                        <h5>Status: <span class="badge badge-success">Sudah Mengumpulkan</span></h5>
                        <p>Jawaban Anda: <a href="{{ asset('storage/' . $quiz->mySubmission->file_path) }}" target="_blank">Lihat File Jawaban</a></p>
                        <hr>
                        <h5>Nilai:</h5>
                        @if($quiz->mySubmission->nilai !== null)
                            <h2 class="display-4 text-success"><strong>{{ $quiz->mySubmission->nilai }}</strong></h2>
                        @else
                            <p class="text-muted">Jawaban Anda sedang menunggu penilaian dari guru.</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Sembunyikan form jika sudah dinilai, atau tampilkan form jika belum pernah submit/belum dinilai --}}
            @if(!$quiz->mySubmission || $quiz->mySubmission->nilai === null)
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">{{ $quiz->mySubmission ? 'Kirim Ulang Jawaban' : 'Kumpulkan Jawaban Anda' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.quiz.submit', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($quiz->mySubmission)
                            <p>Anda dapat mengirim ulang file jawaban selama kuis belum dinilai oleh guru. File sebelumnya akan diganti.</p>
                        @else
                            <p>Silakan kerjakan kuis sesuai petunjuk, lalu upload file jawaban Anda di sini.</p>
                        @endif
                        
                        <div class="form-group">
                            <label for="submission_file" class="font-weight-bold">Lampirkan File Jawaban</label>
                            <input type="file" class="form-control-file" id="submission_file" name="submission_file" required>
                            <small class="form-text text-muted">Format yang diizinkan: PDF, DOC, DOCX, JPG, PNG.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg mt-3">
                            {{ $quiz->mySubmission ? 'Kirim Ulang' : 'Kumpulkan Jawaban' }}
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <a href="{{ route('siswa.quiz.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kuis</a>
        </div>
    </div>
</div>
@endsection