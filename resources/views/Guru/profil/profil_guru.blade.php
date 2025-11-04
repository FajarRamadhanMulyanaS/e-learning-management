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
        border: 3px solid #6a1b9a;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .profile-photo:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 15px rgba(106, 27, 154, 0.3);
    }
</style>

<title>Profil Guru</title>

<div class="container mt-5">
    <div class="bg-primary text-white text-center py-5 rounded shadow-sm mb-3">
        <h1 class="fw-bold">Profil Guru</h1>
        <p class="mb-0">Lihat dan perbarui informasi profil Anda di sini.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0 mb-2">
        <div class="card-body">
            <div class="profile-photo-container text-center">
                <img src="{{ $user->foto ? asset('images/profil_guru/' . $user->foto) : asset('images/default.png') }}"
                    class="profile-photo shadow rounded-circle" alt="Foto Profil">
            </div>

            <hr class="mb-4">

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $user->username }}</p>
                    <p><strong>NIP:</strong> {{ $guru->nip }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Alamat:</strong> {{ $guru->alamat }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Lahir:</strong> {{ $guru->tgl_lahir }}</p>
                    <p><strong>Telepon:</strong> {{ $guru->telepon }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $guru->gender }}</p>
                    <p><strong>Jabatan:</strong> {{ $guru->jabatan }}</p>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    Edit Profil
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Profil Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('guru.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $guru->alamat }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" value="{{ $guru->tgl_lahir }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $guru->telepon }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select" required>
                                <option value="Laki-laki" {{ $guru->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $guru->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ $guru->jabatan }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto" class="form-control">
                            @if ($user->foto)
                                <img src="{{ asset('images/profil_guru/' . $user->foto) }}" class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
