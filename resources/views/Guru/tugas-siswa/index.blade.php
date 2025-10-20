@extends('layout2.app')

@section('konten')
<title>Tugas Siswa</title>
<style>
    .page-title {
        font-weight: bold;
        color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .alert {
        border-radius: 12px;
    }

    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="container mt-5">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="page-title fw-bold text-primary">📋 Daftar Tugas yang Dibuat</h3>
        <!-- Tombol Tambah Tugas -->
        <a href="{{ route('guru.tugas-siswa.create') }}" class="btn btn-primary btn-lg px-4 shadow">
            <i class="fa-solid fa-plus me-2"></i>Buat Tugas Baru
        </a>
    </div>
    <hr class="mt-3 mb-4">
</div>


    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Daftar Tugas -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Pengumpulan Terakhir</th>
                            <th>File</th>
                            <th>Lihat Soal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tugas as $index => $task)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $task->judul }}</td>
                                <td>{{ $task->mapel->nama_mapel ?? 'Mata Pelajaran Tidak Tersedia' }}</td>
                                <td>{{ $task->kelas->nama_kelas ?? 'Kelas Tidak Tersedia' }}</td>
                                <td>{{ $task->tanggal_pengumpulan ? \Carbon\Carbon::parse($task->tanggal_pengumpulan)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($task->file)
                                        <a href="{{ asset('storage/' . $task->file) }}" class="btn btn-sm btn-success" target="_blank">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('guru.tugas-siswa.showguru', $task->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('guru.tugas-siswa.edit', $task->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('guru.tugas-siswa.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada tugas yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
