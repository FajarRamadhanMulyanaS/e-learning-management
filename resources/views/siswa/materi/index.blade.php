@extends('layout2.app')

@section('konten')
<title>Materi</title>
<div class="container mt-5">
    <!-- Judul Halaman -->
    <div class="text-center mb-4">
        <h2 class="font-weight-bold">Pilih Materi Berdasarkan Mata Pelajaran</h2>
        <p class="text-muted">Cari dan akses materi sesuai dengan pelajaran yang Anda ambil</p>
    </div>

    <!-- Tabel Materi -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Materi</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="bg-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengajar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materi as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->mapel->nama_mapel }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.materi.detail', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-book-open"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada materi yang tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $materi->links() }}
    </div>
</div>
@endsection
