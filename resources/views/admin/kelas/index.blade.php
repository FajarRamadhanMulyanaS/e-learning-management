@extends('layout_new.app')

@section('konten')
<div class="bg-light py-1" style="min-height: 100vh;">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h2 class="fw-bold text-primary">Daftar Kelas</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table id="basic-datatables" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Kelas</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $k->kode_kelas }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editKelasModal{{ $k->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Kelas -->
                            <div class="modal fade" id="editKelasModal{{ $k->id }}" tabindex="-1" aria-labelledby="editKelasModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title fw-bold" id="editKelasModalLabel">Edit Kelas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.kelas.update', $k->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="kode_kelas" class="form-label">Kode Kelas</label>
                                                    <input type="text" name="kode_kelas" class="form-control" value="{{ $k->kode_kelas }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                                    <input type="text" name="nama_kelas" class="form-control" value="{{ $k->nama_kelas }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
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

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="tambahKelasModalLabel">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_kelas" class="form-label">Kode Kelas</label>
                        <input type="text" name="kode_kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
