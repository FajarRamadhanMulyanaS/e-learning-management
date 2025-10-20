@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="row">
        {{-- Kolom Kiri: Detail Kuis & Lampiran --}}
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Kuis</h4>
                    <a href="{{ route('guru.quiz.edit', $quiz->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-edit"></i> Edit Kuis
                    </a>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $quiz->judul }}</h3>
                    <p class="text-muted">
                        {{ $quiz->guruMapel->mapel->nama_mapel }} - Kelas {{ $quiz->guruMapel->kelas->nama_kelas }}
                    </p>
                    <hr>
                    <h5 class="font-weight-bold">Deskripsi / Petunjuk</h5>
                    <p>{!! nl2br(e($quiz->description)) !!}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Lampiran</h5>
                </div>
                <div class="card-body">
                    @if($quiz->attachment_file || $quiz->attachment_link || $quiz->attachment_image)
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
                    @else
                        <p class="text-muted">Tidak ada lampiran untuk kuis ini.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi Selanjutnya --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                 <div class="card-header">
                    <h5 class="mb-0">Kelola Quizz</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('guru.quiz.index') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus-circle"></i> Kembali ke Daftar Quizz
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection