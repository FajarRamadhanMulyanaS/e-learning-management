@extends('layout2.app')

@section('konten')

<style>
    .table-responsive {
        overflow-x: auto;
    }
    .card {
        border: none;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .btn {
        transition: background-color 0.3s, color 0.3s;
    }
    .btn:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<title>Manajemen Ujian</title>
<div class="container my-3">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="m-0">Menu Manajemen Ujian / Tugas</h3>
            <a href="{{ route('guru.manajemen-ujian.create') }}" class="btn btn-light text-primary shadow-sm">
                + Tambah Ujian
            </a>
        </div>
        <div class="card-body">
            <h4 class="mb-3">Daftar Tugas dan Ujian</h4>
            <p class="text-muted">
                Anda dapat mengelola tugas dan ujian yang akan diberikan kepada siswa di sini.
                Klik tombol <strong>+ Tambah Ujian</strong> untuk menambahkan ujian baru.
            </p>
        </div>
    </div>
</div>


    <div class="row">
        @foreach($ujianTugas as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $item->judul }}</h5>
                    <p class="card-text text-muted">{{ $item->info_ujian }}</p>
                    <p><strong>Mata Pelajaran:</strong> {{ $item->mapel->nama_mapel }}</p>
                    <p><strong>Waktu Pengerjaan:</strong> {{ $item->waktu_pengerjaan }} menit</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('guru.manajemen-ujian.koreksi.daftar-siswa', $item->id) }}" class="btn btn-success btn-sm shadow">
                        <i class="fa-solid fa-eye"></i> Koreksi
                    </a>
                    <a href="{{ route('guru.manajemen-ujian.detailsoal', $item->id) }}" class="btn btn-info btn-sm shadow">
                        <i class="fa-solid fa-magnifying-glass"></i> Soal
                    </a>
                    <button type="button" class="btn btn-warning btn-sm shadow" data-toggle="modal" data-target="#editUjianModal-{{ $item->id }}">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <form action="{{ route('guru.manajemen-ujian.destroy', $item->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm shadow" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Ujian -->
        <div class="modal fade" id="editUjianModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editUjianLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUjianLabel">Edit Ujian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('guru.manajemen-ujian.update', $item->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="judul">Judul Ujian</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ $item->judul }}" required>
                            </div>
                            <div class="form-group">
                                <label for="mapel">Mata Pelajaran</label>
                                <select class="form-control" id="mapel" name="mapel_id">
                                    @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}" {{ $item->mapel_id == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select class="form-control" id="kelas" name="kelas_id">
                                    @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $item->kelas_id == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="waktu_pengerjaan">Waktu Pengerjaan (Menit)</label>
                                <input type="number" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" value="{{ $item->waktu_pengerjaan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="info">Info Ujian</label>
                                <textarea class="form-control" id="info" name="info_ujian" rows="2" required>{{ $item->info_ujian }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="bobot_pilihan_ganda">Bobot Pilihan Ganda (%)</label>
                                <input type="number" class="form-control" id="bobot_pilihan_ganda" name="bobot_pilihan_ganda" value="{{ $item->bobot_pilihan_ganda }}" required>
                            </div>
                            <div class="form-group">
                                <label for="bobot_essay">Bobot Essay (%)</label>
                                <input type="number" class="form-control" id="bobot_essay" name="bobot_essay" value="{{ $item->bobot_essay }}" required>
                            </div>
                            <div class="form-group">
                                <label for="terbit">Terbit?</label>
                                <select class="form-control" id="terbit" name="terbit">
                                    <option value="Y" {{ $item->terbit == 'Y' ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ $item->terbit == 'N' ? 'selected' : '' }}>N</option>
                                </select>
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
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            Menampilkan {{ $ujianTugas->firstItem() }} - {{ $ujianTugas->lastItem() }} dari {{ $ujianTugas->total() }} Ujian
        </div>
        <div>
            {{ $ujianTugas->links() }}
        </div>
    </div>
</div>

@endsection
