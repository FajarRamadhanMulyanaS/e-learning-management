@extends('layout_new.app')

@section('konten')
<div class="container mt-3">
    <div class="card-body bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Daftar Semester</h2>
            <div class="d-flex gap-2">
                <!-- Tombol untuk menambah semester -->
                <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addSemesterModal">
                    + Tambah Semester
                </button>
                
                <!-- Tombol kembali ke master mapel -->
                <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary rounded-pill shadow-sm">
                    <i class="fas fa-arrow-left"></i> Kembali ke Mapel
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card untuk tabel data -->
        <div class="card shadow-sm border-0 rounded">
            <div class="card-body">
                <!-- Tabel untuk data semester -->
                <table class="table table-striped table-hover" id="basic-datatables">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semesters as $semester)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $semester->nama_semester }}</td>
                            <td>{{ $semester->tahun_ajaran }}</td>
                            <td>{{ $semester->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>{{ $semester->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>
                                @if($semester->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#editSemesterModal-{{ $semester->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Tombol Aktifkan -->
                                @if(!$semester->is_active)
                                    <a href="{{ route('admin.semester.activate', $semester->id) }}" class="btn btn-success btn-sm rounded-pill">
                                        <i class="fas fa-check"></i> Aktifkan
                                    </a>
                                @endif

                                <!-- Form Hapus -->
                                <form action="{{ route('admin.semester.delete', $semester->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Yakin ingin menghapus semester ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Semester -->
                        <div class="modal fade" id="editSemesterModal-{{ $semester->id }}" tabindex="-1" aria-labelledby="editSemesterModalLabel-{{ $semester->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded">
                                    <div class="modal-header bg-light text-secondary">
                                        <h5 class="modal-title" id="editSemesterModalLabel-{{ $semester->id }}">Edit Semester</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.semester.update', $semester->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nama_semester" class="form-label">Nama Semester</label>
                                                <input type="text" class="form-control" id="nama_semester" name="nama_semester" value="{{ $semester->nama_semester }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ $semester->tahun_ajaran }}" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $semester->tanggal_mulai->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $semester->tanggal_selesai->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $semester->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $semester->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Aktifkan semester ini
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Semester -->
<div class="modal fade" id="addSemesterModal" tabindex="-1" aria-labelledby="addSemesterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded">
            <div class="modal-header bg-light text-secondary">
                <h5 class="modal-title" id="addSemesterModalLabel">Tambah Semester</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.semester.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_semester" class="form-label">Nama Semester</label>
                        <input type="text" class="form-control" id="nama_semester" name="nama_semester" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="Contoh: 2024/2025" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1">
                            <label class="form-check-label" for="is_active">
                                Aktifkan semester ini
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
