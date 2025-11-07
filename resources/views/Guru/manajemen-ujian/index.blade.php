@extends('layout2.app')

@section('konten')

<title>Manajemen Ujian</title>

<style>
    .table-responsive {
        overflow-x: auto;
    }
    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn:hover {
        opacity: 0.9;
    }
    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .modal-content {
        border-radius: 12px;
    }
    .modal-header {
        background-color: #0d6efd;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>

<div class="container py-4">
    <!-- Header -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h4 class="m-0"><i class="fa-solid fa-clipboard-list me-2"></i>Manajemen Ujian / Tugas</h4>
            <a href="{{ route('guru.manajemen-ujian.create') }}" class="btn btn-light text-primary fw-semibold">
                <i class="fa-solid fa-plus me-1"></i> Tambah Ujian
            </a>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0">
                Kelola semua tugas dan ujian yang akan diberikan kepada Pelajar di halaman ini.
                Klik tombol <strong>Tambah Ujian</strong> untuk membuat ujian baru.
            </p>
        </div>
    </div>

    <!-- Daftar Ujian -->
    <div class="row">
        @forelse($ujianTugas as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary fw-bold">{{ $item->judul }}</h5>
                    <p class="text-muted mb-2">{{ $item->info_ujian }}</p>
                    <ul class="list-unstyled small">
                        <li><strong>Mata Pelajaran:</strong> {{ $item->mapel->nama_mapel }}</li>
                        <li><strong>Waktu Pengerjaan:</strong> {{ $item->waktu_pengerjaan }} menit</li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between">
                    <a href="{{ route('guru.manajemen-ujian.koreksi.daftar-siswa', $item->id) }}" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-eye"></i> Koreksi
                    </a>
                    <a href="{{ route('guru.manajemen-ujian.detailsoal', $item->id) }}" class="btn btn-info btn-sm text-white">
                        <i class="fa-solid fa-magnifying-glass"></i> Soal
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUjianModal-{{ $item->id }}">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <form action="{{ route('guru.manajemen-ujian.destroy', $item->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editUjianModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editUjianLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUjianLabel-{{ $item->id }}">Edit Ujian</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('guru.manajemen-ujian.update', $item->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Ujian</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ $item->judul }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="mapel" class="form-label">Mata Pelajaran</label>
                                <select class="form-select" id="mapel" name="mapel_id">
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->id }}" {{ $item->mapel_id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select class="form-select" id="kelas" name="kelas_id">
                                    @foreach($kelases as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $item->kelas_id == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_pengerjaan" class="form-label">Waktu Pengerjaan (Menit)</label>
                                <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" value="{{ $item->waktu_pengerjaan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="info" class="form-label">Info Ujian</label>
                                <textarea class="form-control" id="info" name="info_ujian" rows="2" required>{{ $item->info_ujian }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="bobot_pilihan_ganda" class="form-label">Bobot Pilihan Ganda (%)</label>
                                <input type="number" class="form-control" id="bobot_pilihan_ganda" name="bobot_pilihan_ganda" value="{{ $item->bobot_pilihan_ganda }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="bobot_essay" class="form-label">Bobot Essay (%)</label>
                                <input type="number" class="form-control" id="bobot_essay" name="bobot_essay" value="{{ $item->bobot_essay }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="terbit" class="form-label">Terbit?</label>
                                <select class="form-select" id="terbit" name="terbit">
                                    <option value="Y" {{ $item->terbit == 'Y' ? 'selected' : '' }}>Ya</option>
                                    <option value="N" {{ $item->terbit == 'N' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center shadow-sm">
                <i class="fa-solid fa-circle-info me-2"></i>Belum ada ujian atau tugas yang dibuat.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($ujianTugas->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <small class="text-muted">
            Menampilkan {{ $ujianTugas->firstItem() }}–{{ $ujianTugas->lastItem() }} dari {{ $ujianTugas->total() }} Ujian
        </small>
        <div>
            {{ $ujianTugas->links() }}
        </div>
    </div>
    @endif
</div>

@endsection
