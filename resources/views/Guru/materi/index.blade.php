@extends('layout2.app')
@section('konten')

<style>
    .modal-header {
        background-color: #007bff;
        color: #fff;
    }
    .modal-title {
        font-weight: bold;
    }
    .table {
        background-color: #fff;
    }
    .table thead th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
    }
    .table tbody td {
        text-align: center;
        vertical-align: middle;
    }
    .btn {
        font-size: 0.9rem;
    }
    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }

</style>

<title>Materi</title>
<div class="container my-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="m-0">Menu Manajemen Teori</h3>
        <button type="button" class="btn btn-light text-primary shadow-sm" data-toggle="modal" data-target="#tambahMateriModal">
            Tambah Materi
        </button>
    </div>
    <div class="card-body">
        <h4 class="mb-3">Daftar Materi</h4>
        <p class="text-muted">
            Anda dapat mengelola materi yang akan diberikan kepada Pelajar di sini.
            Klik tombol <strong>+ Tambah Materi</strong> untuk menambahkan Materi baru.
        </p>
    </div>
</div>


    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <!-- Tabel Daftar Materi -->
    <div class="table-responsive">
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materi as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->judul }}</td>
                    <td>{{ $m->mapel->nama_mapel }}</td>
                    <td>{{ $m->kelas->nama_kelas }}</td>
                    <td><a href="{{ asset('storage/' . $m->file_path) }}" target="_blank" class="btn btn-link">Lihat File</a></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMateriModal{{ $m->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('guru.materi.destroy', $m->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

                <!-- Modal Edit Materi -->
                <div class="modal fade" id="editMateriModal{{ $m->id }}" tabindex="-1" role="dialog" aria-labelledby="editMateriModalLabel{{ $m->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMateriModalLabel{{ $m->id }}">Edit Materi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('guru.materi.update', $m->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="judul">Judul Modul / Materi</label>
                                        <input type="text" name="judul" class="form-control" value="{{ $m->judul }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mapel_id">Mata Pelajaran</label>
                                        <select name="mapel_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                            @foreach($mapels as $mapel)
                                                <option value="{{ $mapel->mapel->id }}" {{ $m->mapel_id == $mapel->mapel->id ? 'selected' : '' }}>{{ $mapel->mapel->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="kelas_id">Kelas</label>
                                        <select name="kelas_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Kelas</option>
                                            @foreach($mapels as $kelas)
                                                <option value="{{ $kelas->kelas->id }}" {{ $m->kelas_id == $kelas->kelas->id ? 'selected' : '' }}>{{ $kelas->kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label>
                                        <input type="file" name="file" class="form-control-file">
                                        <small>Upload file jika ingin mengganti</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada materi yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

<!-- Modal Tambah Materi -->
<div class="modal fade" id="tambahMateriModal" tabindex="-1" role="dialog" aria-labelledby="tambahMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMateriModalLabel">Tambah Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul Modul / Materi</label>
                        <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukkan judul materi" required>
                    </div>
                    <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" id="mapel_id" required>
                            <option value="" disabled selected>Pilih Mata Pelajaran</option>
                            @foreach($mapels as $guruMapel)
                                <option value="{{ $guruMapel->mapel->id }}">{{ $guruMapel->mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" class="form-control" id="kelas_id" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach($mapels as $guruMapel)
                                <option value="{{ $guruMapel->kelas->id }}">{{ $guruMapel->kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="file" class="form-control-file" id="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
