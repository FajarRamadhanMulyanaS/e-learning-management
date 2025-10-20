@extends('layout2.app')

@section('konten')

<style>
    .profile-photo-container {
    margin: 20px auto;
    }

    .profile-photo {
        width: 150px;
        height: 200px;
        object-fit: cover;
        border: 3px solid #6a1b9a; /* Warna border */
        transition: transform 0.3s, box-shadow 0.3s; /* Animasi efek */
    }

    .profile-photo:hover {
        transform: scale(1.1); /* Efek zoom */
        box-shadow: 0 8px 15px rgba(106, 27, 154, 0.3); /* Bayangan lebih besar saat hover */
    }

</style>
<title>Profil</title>
<div class="container mt-5">
    <!-- Header -->
    <div class="bg-primary text-white text-center py-5 rounded shadow-sm mb-3">
        <h1 class="fw-bold">Profil Guru</h1>
        <p class="mb-0">Lihat dan perbarui informasi profil Anda di sini.</p>
    </div>

    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

    <!-- Pesan Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">✓</button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Profil -->
    <div class="card shadow border-0 mb-2">
        <div class="card-body">
            <!-- Foto Profil -->
            <div class="profile-photo-container text-center">
                <img src="{{ $guruData->foto ? asset('images/profil_guru/' . $guruData->foto) : asset('images/default.png') }}"
                    class="profile-photo shadow rounded-circle"
                    alt="Profil Guru">
            </div>


            <!-- Divider -->
            <hr class="mb-4">

            <!-- Informasi Profil -->
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Nama:</strong> <span class="text-muted">{{ $guruData->nama }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>NIP:</strong> <span class="text-muted">{{ $guruData->nip }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> <span class="text-muted">{{ $guruData->email }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Alamat:</strong> <span class="text-muted">{{ $guruData->alamat }}</span>
                    </div>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong>Tanggal Lahir:</strong> <span class="text-muted">{{ $guruData->tgl_lahir }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Telepon:</strong> <span class="text-muted">{{ $guruData->telepon }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Jenis Kelamin:</strong> <span class="text-muted">{{ $guruData->gender }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Jabatan:</strong> <span class="text-muted">{{ $guruData->jabatan }}</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Edit -->
            <div class="text-center mt-4">
                <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    Edit Profil
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <form action="{{ route('guru.profil.updateProfilGuru', ['id' => $guruData->user_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Form Input -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $guruData->nama }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $guruData->nip }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $guruData->email }}" >
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $guruData->alamat }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $guruData->jabatan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $guruData->tgl_lahir }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $guruData->telepon }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="Laki-laki" {{ $guruData->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $guruData->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            @if ($guruData->foto)
                                <img src="{{ asset('images/profil_guru/' . $guruData->foto) }}" alt="Foto Profil" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
