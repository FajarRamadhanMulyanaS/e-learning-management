@extends('layout_new.app')

@section('konten')
<div class="container mt-3">
    <div class="card-body bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">Daftar Mata Pelajaran</h2>
            <div class="d-flex gap-2">
                <!-- Filter Semester -->
                <form method="GET" action="{{ route('admin.mapel.index') }}" class="d-flex gap-2">
                    <select name="semester_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $selectedSemester == $semester->id ? 'selected' : '' }}>
                                {{ $semester->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </form>
                
                <!-- Tombol untuk menambah mata pelajaran -->
                <button type="button" class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addMapelModal">
                    + Tambah Mata Pelajaran
                </button>
                
                <!-- Tombol Manajemen Semester -->
                <a href="{{ route('admin.semester.index') }}" class="btn btn-success rounded-pill shadow-sm">
                    <i class="fas fa-calendar-alt"></i> Kelola Semester
                </a>
            </div>
        </div>

    <!-- Card untuk tabel data -->
    <div class="card shadow-sm border-0 rounded">
        <div class="card-body">
            <!-- Tabel untuk data mata pelajaran -->
            <table class="table table-striped table-hover" id="basic-datatables">
                <thead class="bg-dark text-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Mata Pelajaran</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapels as $mapel)
                    <tr class="align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mapel->kode_mapel }}</td>
                        <td>{{ $mapel->nama_mapel }}</td>
                        <td>
                            @if($mapel->semester)
                                <span class="badge bg-info">{{ $mapel->semester->nama_lengkap }}</span>
                            @else
                                <span class="badge bg-secondary">Belum Ditentukan</span>
                            @endif
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#editMapelModal-{{ $mapel->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <!-- Form Hapus -->
                            <form action="{{ route('admin.mapel.delete', $mapel->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit Mapel -->
                    <div class="modal fade" id="editMapelModal-{{ $mapel->id }}" tabindex="-1" aria-labelledby="editMapelModalLabel-{{ $mapel->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded">
                                <div class="modal-header bg-light text-secondary">
                                    <h5 class="modal-title" id="editMapelModalLabel-{{ $mapel->id }}">Edit Mata Pelajaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="mb-3">
                                            <label for="kode_mapel" class="form-label">Kode Mata Pelajaran</label>
                                            <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" value="{{ $mapel->kode_mapel }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="{{ $mapel->nama_mapel }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="semester_id" class="form-label">Semester</label>
                                            <select class="form-select" id="semester_id" name="semester_id" required>
                                                <option value="">Pilih Semester</option>
                                                @foreach($semesters as $semester)
                                                    <option value="{{ $semester->id }}" {{ $mapel->semester_id == $semester->id ? 'selected' : '' }}>
                                                        {{ $semester->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
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

<!-- Modal Tambah Mapel -->
<div class="modal fade" id="addMapelModal" tabindex="-1" aria-labelledby="addMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded">
            <div class="modal-header bg-light text-secondary">
                <h5 class="modal-title" id="addMapelModalLabel">Tambah Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMapelForm" action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_mapel" class="form-label">Kode Mata Pelajaran</label>
                        <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
                    </div>
                    <div class="mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-select" id="semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
