@extends('layout_siswa.app')

@section('konten')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-upload mr-2"></i> Pengumpulan Tugas</h3>
        </div>
        <div class="card-body">
            <h5 class="text-primary mb-4">Judul Tugas: {{ $tugas->judul }}</h5>
            <form action="{{ route('siswa.tugas.submitTugas', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Form input file -->
                <div class="form-group">
                    <label for="file_pengumpulan" class="text-muted">Unggah Tugas (PDF, DOCX, JPG, PNG)</label>
                    <input type="file" name="file_pengumpulan" class="form-control" accept=".pdf,.doc,.docx,.jpeg,.jpg,.png" required>
                </div>

                <!-- Komentar tambahan -->
                <div class="form-group mt-3">
                    <label for="komentar" class="text-muted">Komentar (Opsional)</label>
                    <textarea name="komentar" class="form-control" rows="3" placeholder="Tambahkan komentar jika perlu"></textarea>
                </div>

                <!-- Tombol submit -->
                <button type="submit" class="btn btn-success mt-3"><i class="fas fa-paper-plane mr-2"></i> Submit Tugas</button>
            </form>

            <!-- Tombol kembali -->
            <div class="mt-4 text-center">
                <a href="{{ route('siswa.tugas.show', $tugas->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
