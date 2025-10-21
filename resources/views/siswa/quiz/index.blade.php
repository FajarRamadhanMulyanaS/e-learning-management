@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold">Daftar Kuis</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Judul Kuis</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Nilai</th> {{-- 1. Tambah Kolom Nilai --}}
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $quiz)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $quiz->judul }}</td>
                                <td>{{ $quiz->guruMapel->mapel->nama_mapel }}</td>
                                <td>{{ $quiz->guruMapel->user->username }}</td>
                                <td class="text-center">
                                    @if($quiz->mySubmission)
                                        <span class="badge badge-success">Sudah Dikerjakan</span>
                                    @else
                                        <span class="badge badge-warning">Belum Dikerjakan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- 2. Logika untuk menampilkan nilai --}}
                                    <strong>{{ $quiz->mySubmission->nilai ?? '-' }}</strong>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('siswa.quiz.show', $quiz->id) }}" class="btn btn-sm btn-primary">
                                        @if($quiz->mySubmission)
                                            Lihat Detail
                                        @else
                                            Kerjakan
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada kuis yang tersedia untuk kelas Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection