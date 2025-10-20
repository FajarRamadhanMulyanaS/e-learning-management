@extends('layout2.app')

@section('konten')
<div class="container mt-5">
    <!-- Header Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="d-inline-block">Menu Manajemen Ujian / Tugas</h3>
            <a href="{{ route('siswa.ujian.index') }}" class="btn btn-secondary float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Ujian Info Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-light">
            <h5>Daftar Ujian Oleh <span class="text-info">{{ $ujian->guru->user->username ?? 'Guru Tidak Ditemukan' }}</span></h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Mapel</th>
                        <th>Waktu</th>
                        <th>Kerjakan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $ujian->judul }}</td>
                        <td>{{ $ujian->mapel->nama_mapel ?? 'Mapel Tidak Ditemukan' }}</td>
                        <td>{{ $ujian->waktu_pengerjaan }} Menit</td>
                        <td class="text-center">
                            <a href="{{ route('siswa.ujian.kerjakan', $ujian->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-play"></i> Kerjakan
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
