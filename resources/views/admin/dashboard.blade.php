@extends('layout_new.app')

@section('konten')

<title>Dashboard</title>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h1 class="display-4 text-primary">Dashboard Admin</h1>
            <p class="text-muted">Informasi Singkat Mengenai Data Sekolah</p>
            <hr class="my-4" style="width: 200px; border-top: 3px solid #0d6efd;">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0 rounded-lg text-center bg-primary text-light" style="transition: transform 0.3s;">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="fas fa-user-graduate fa-3x"></i>
                    </div>
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="card-text display-5">{{ $totalSiswa }}</p>
                    <p class="text-light">Siswa</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0 rounded-lg text-center bg-success text-light" style="transition: transform 0.3s;">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                    </div>
                    <h5 class="card-title">Total Guru</h5>
                    <p class="card-text display-5">{{ $totalGuru }}</p>
                    <p class="text-light">Guru</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow border-0 rounded-lg text-center bg-warning text-light" style="transition: transform 0.3s;">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <i class="fas fa-book fa-3x"></i>
                    </div>
                    <h5 class="card-title">Total Mata Pelajaran</h5>
                    <p class="card-text display-5">{{ $totalMataPelajaran }}</p>
                    <p class="text-light">Pelajaran</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
