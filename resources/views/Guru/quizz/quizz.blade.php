@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold">Manajemen Kuis</h3>
        <a href="{{ route('guru.quiz.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kuis
        </a>
    </div>

    {{-- Pesan notifikasi setelah berhasil membuat kuis --}}
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
                            <th>Kelas</th>
                            <th>Jumlah Soal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Gunakan @forelse untuk loop data quizzes --}}
                        @forelse($quizzes as $quiz)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $quiz->judul }}</td>
                                <td>{{ $quiz->guruMapel->mapel->nama_mapel }}</td>
                                <td>{{ $quiz->guruMapel->kelas->nama_kelas }}</td>
                                <td>0</td> {{-- Placeholder, akan diisi nanti saat soal sudah dibuat --}}
                                <td class="text-center">
                                    {{-- Tombol aksi (Detail, Edit, Hapus) --}}
                                    <a href="{{ route('guru.quiz.show', $quiz->id) }}" class="btn btn-sm btn-info">Nilai</a>
                                    <a href="{{ route('guru.quiz.edit', $quiz->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('guru.quiz.destroy', $quiz->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus kuis ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan ini akan muncul jika $quizzes kosong --}}
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada kuis yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection