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
<div class="container my-2">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Profil Siswa</h3>
        </div>
        <div class="card-body p-5">
            <div class="profile-photo-container text-center">
                <img src="{{ $user->foto ? asset('images/profil_siswa/' . $user->foto) : asset('images/default.png') }}"
                 class="profile-photo shadow rounded-circle"
                 alt="Foto Profil">
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-fill me-2 text-primary"></i><strong>Nama:</strong></span>
                    <span>{{ $user->username }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-fill me-2 text-primary"></i><strong>Email:</strong></span>
                    <span>{{ $user->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-card-text me-2 text-primary"></i><strong>NIS:</strong></span>
                    <span>{{ $siswa->nis }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-card-heading me-2 text-primary"></i><strong>NISN:</strong></span>
                    <span>{{ $siswa->nisn }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-geo-alt-fill me-2 text-primary"></i><strong>Alamat:</strong></span>
                    <span>{{ $siswa->alamat }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-telephone-fill me-2 text-primary"></i><strong>Telepon:</strong></span>
                    <span>{{ $siswa->telepon }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-building me-2 text-primary"></i><strong>Kelas:</strong></span>
                    <span>{{ $kelas->nama_kelas }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-gender-ambiguous me-2 text-primary"></i><strong>Gender:</strong></span>
                    <span>{{ $siswa->gender }}</span>
                </li>
            </ul>
            <div class="text-center mt-4">
                <a href="{{ route('siswa.profil.edit') }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
