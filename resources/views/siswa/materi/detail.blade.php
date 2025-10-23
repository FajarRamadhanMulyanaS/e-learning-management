@extends('layout_siswa.app') <!-- Pastikan layout utama digunakan -->

@section('konten')
<style>
    .content-wrapper {
    margin-top: 20px;
}

.card {
    border-radius: 8px;
    overflow: hidden;
}

.card-header {
    font-weight: bold;
}

.card-title {
    font-weight: 600;
}

.table thead th {
    text-align: center;
    font-weight: 600;
    background-color: #f9fafb;
}

.table tbody td {
    vertical-align: middle;
}

.btn-outline-light {
    font-size: 14px;
}

.btn-success {
    font-weight: 600;
}

.btn-success:hover {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-primary, .btn-outline-light {
    border-radius: 20px;
}

</style>
<title>Detail Materi</title>
<div class="container content-wrapper mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="m-0">📚 Modul / Materi</h4>
            <button class="btn btn-outline-dark btn-sm" onclick="history.back()">⬅ Kembali</button>
        </div>
        <div class="card-body">
            <h5 class="card-title text-primary">📄 Detail Materi</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Mata Pelajaran:</strong> {{ $materi->mapel->nama_mapel ?? 'Mata Pelajaran Tidak Ditemukan' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Guru / Pengajar:</strong> {{ $materi->user->username }}</p>
                </div>
            </div>

            <table class="table table-bordered table-hover mt-4">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Materi/Modul</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $materi->judul }}</td>
                        <td>
                            <a href="{{ Storage::url($materi->file_path) }}" class="btn btn-success btn-sm" download>
                                ⬇ Download
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
