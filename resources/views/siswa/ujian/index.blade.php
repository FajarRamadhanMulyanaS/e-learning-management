@extends('layout2.app')

@section('konten')
<title>Ujian</title>
<div class="container mt-5">
    <!-- Header Section -->
    <div class="text-center mb-4">
        <h3 class="font-weight-bold">Menu Manajemen Ujian / Tugas</h3>
        <p class="text-muted">Daftar Ujian berdasarkan Mata Pelajaran dan Pengajar</p>
    </div>

    <!-- Tabel Ujian -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Ujian</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead class="bg-dark text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Pengajar</th>
                        <th>Jumlah Ujian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ujians as $ujian)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $ujian->mapel ? $ujian->mapel->nama_mapel : 'Tidak ada mapel' }}</td>
                            <td>{{ $ujian->guru ? $ujian->guru->user->username : 'Tidak ada guru' }}</td>
                            <td class="text-center">{{ $ujian->guru_count }}</td> <!-- Jumlah Ujian -->
                            <td class="text-center">
                                @if (isset($ujian->id))
                                    <a href="{{ route('siswa.ujian.view', $ujian->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-search"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
