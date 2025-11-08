@extends('layout_siswa.app')

@section('konten')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-edit mr-2"></i> Edit Pengumpulan Tugas</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Detail Tugas -->
                <div class="col-md-6">
                    <h5 class="text-primary"><i class="fas fa-file-alt mr-2"></i> Judul Tugas</h5>
                    <p class="text-muted">{{ $tugas->judul }}</p>

                    <h5 class="text-primary"><i class="fas fa-book mr-2"></i> Mata Pelajaran</h5>
                    <p class="text-muted">{{ $tugas->mapel->nama_mapel ?? 'Tidak ada' }}</p>

                    <h5 class="text-primary"><i class="fas fa-chalkboard-teacher mr-2"></i> Pengajar</h5>
                    <p class="text-muted">{{ $tugas->guru->username ?? 'Tidak ada' }}</p>
                </div>

                <!-- Form Edit Pengumpulan -->
                <div class="col-md-6">
                    <form action="{{ route('siswa.tugas.updateTugasSiswa', $pengumpulan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="file_tugas" class="text-primary"><i class="fas fa-paperclip mr-2"></i> Update File Tugas</label>
                            <input type="file" name="file_tugas" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
                        </div>

                        <div class="form-group">
                            <label for="komentar" class="text-primary"><i class="fas fa-comment mr-2"></i> Komentar</label>
                            <textarea name="komentar" class="form-control">{{ $pengumpulan->komentar }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-2"></i> Update Pengumpulan</button>
                    </form>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 text-center">
                <a href="{{ route('siswa.tugas.show', $tugas->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
