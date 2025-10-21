@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Kuis: {{ $quiz->judul }}</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">
                {{ $quiz->guruMapel->mapel->nama_mapel }} - Kelas {{ $quiz->guruMapel->kelas->nama_kelas }}
            </p>
            <hr>
            <h5 class="font-weight-bold">Deskripsi / Petunjuk</h5>
            <p>{!! nl2br(e($quiz->description)) !!}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Jawaban Siswa</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Waktu Mengumpulkan</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                // Cek apakah siswa ini sudah mengumpulkan jawaban
                                $submission = $submissions->get($student->id);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->username }}</td>
                                <td>{{ $submission ? $submission->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    @if($submission)
                                        <span class="badge badge-success">Sudah Mengerjakan</span>
                                    @else
                                        <span class="badge badge-warning">Belum Mengerjakan</span>
                                    @endif
                                </td>
                                <td><strong>{{ $submission->nilai ?? '-' }}</strong></td>
                                <td class="text-center">
                                    @if($submission)
                                        {{-- Tombol ini akan kita fungsikan selanjutnya --}}
                                        <a href="{{ route('guru.quiz.grade', $submission->id) }}" class="btn btn-sm btn-info">Lihat & Nilai</a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Belum Ada Jawaban</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('guru.quiz.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kuis</a>
</div>
@endsection