@extends('layout2.app')

@section('konten')

<style>
#loading {
    display: none; /* Spinner default tersembunyi */
}

#loading .spinner-border {
    width: 3rem;
    height: 3rem;
}

    .btn-custom {
        background-color: #4CAF50;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #45a049;
        transform: scale(1.05);
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .modal-header {
        background: linear-gradient(90deg, #4CAF50, #45a049);
        color: white;
        border-radius: 0.3rem 0.3rem 0 0;
    }

    .modal-title {
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(76, 175, 80, 0.05);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(76, 175, 80, 0.1);
    }

    .modal-footer {
        background-color: #f9f9f9;
    }

    .btn-close:focus {
        box-shadow: none;
    }

    .table thead th {
        background: #f4f4f4;
        color: #333;
        font-weight: bold;
    }

    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }

    /* Card Styling untuk Error & Success */
    .alert {
        animation: fadeIn 0.5s ease;
        border-left: 5px solid;
    }

    .alert-success {
        border-color: #4CAF50;
    }

    .alert-danger {
        border-color: #ff4d4d;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Tambahan styling untuk card dan table */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        text-align: center;
        font-size: 18px;
    }

    .card-body {
        padding: 20px;
    }

    .btn-custom {
        background-color: #4CAF50;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #45a049;
        transform: scale(1.05);
        color: #fff;
    }
</style>
<title>Manajemen Video</title>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chalkboard-teacher"></i> Manajemen Video Guru
        </div>
        <div class="card-body">
            <!-- Pesan Error untuk Validasi -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Tombol Upload Video -->
            <div class="text-center mb-4">
                <button class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#uploadLokalModal">
                    <i class="fas fa-upload"></i> Upload dari Lokal
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadYoutubeModal">
                    <i class="fab fa-youtube"></i> Upload dari YouTube
                </button>
            </div>

            <!-- Tabel Daftar Video -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Video</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Link/Path</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $index => $video)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $video->judul }}</td>
                            <td>{{ $video->mapel->nama_mapel ?? 'Tidak Ada Mapel' }}</td>
                            <td>{{ $video->kelas->nama_kelas ?? 'Tidak Ada Kelas' }}</td>
                            <td>
                                @if($video->link_youtube)
                                <a href="{{ $video->link_youtube }}" target="_blank" class="text-primary"><i class="fab fa-youtube"></i> Lihat Video</a>
                                @else
                                <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank" class="text-success"><i class="fas fa-file-video"></i> Lihat Video</a>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('guru.video.destroy', $video->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Belum ada video yang diunggah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload dari Lokal -->
<div class="modal fade" id="uploadLokalModal" tabindex="-1" aria-labelledby="uploadLokalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadLokalModalLabel">
                    <i class="fas fa-upload"></i> Upload Video dari Lokal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{ route('guru.video.store.local') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Spinner loading -->
    <div id="loading" class="text-center" style="display: none;">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Mengunggah file, harap tunggu...</p>
    </div>
                    <p class="text-muted mb-4">
                        Silakan unggah video Anda dari perangkat lokal. Pastikan format file sesuai dengan yang diizinkan
                        (misalnya, MP4, AVI).
                    </p>

                    <div class="mb-3">
                        <label for="judul" class="form-label"><b>Judul Video</b></label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul video" required>
                    </div>
                    <div class="mb-3">
                        <label for="mapel_id" class="form-label"><b>Mata Pelajaran</b></label>
                        <select class="form-control" id="mapel_id" name="mapel_id" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label"><b>Kelas</b></label>
                        <select class="form-control" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label"><b>File Video</b></label>
                        <input type="file" class="form-control" id="file" name="file" accept="video/*" required>
                        <small class="text-muted">Ukuran maksimal: 100 MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-custom"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Upload dari YouTube -->
<div class="modal fade" id="uploadYoutubeModal" tabindex="-1" aria-labelledby="uploadYoutubeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadYoutubeModalLabel">
                    <i class="fab fa-youtube"></i> Upload Video dari YouTube
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form action="{{ route('guru.video.store.youtube') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        Masukkan tautan YouTube dari video yang ingin Anda tambahkan. Pastikan video sesuai dengan materi
                        yang diajarkan.
                    </p>
                    <div class="mb-3">
                        <label for="judul" class="form-label"><b>Judul Video</b></label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul video" required>
                    </div>
                    <div class="mb-3">
                        <label for="mapel_id" class="form-label"><b>Mata Pelajaran</b></label>
                        <select class="form-control" id="mapel_id" name="mapel_id" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label"><b>Kelas</b></label>
                        <select class="form-control" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="link_youtube" class="form-label"><b>Link YouTube</b></label>
                        <input type="url" class="form-control" id="link_youtube" name="link_youtube" placeholder="https://youtube.com/..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-custom"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#uploadForm'); // Form dalam modal
        const loading = document.getElementById('loading'); // Spinner
        const formContent = document.getElementById('formContent'); // Isi formulir

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form refresh halaman

            // Sembunyikan form dan tampilkan spinner
            formContent.style.display = 'none';
            loading.style.display = 'block';

            // Simulasi pengiriman form (ganti dengan AJAX atau proses server-side Anda)
            setTimeout(function () {
                alert('File berhasil diupload!');
                formContent.style.display = 'block'; // Kembalikan form
                loading.style.display = 'none'; // Sembunyikan spinner
                form.reset(); // Reset form
            }, 3000); // Simulasi 3 detik
        });
    });
</script>

@endsection
