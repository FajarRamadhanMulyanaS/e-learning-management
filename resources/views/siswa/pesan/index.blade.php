@extends('layout_siswa.app')

@section('konten')

<style>
    .table thead th {
        background-color: #007bff;
        color: white;
        text-transform: uppercase;
    }

    .table tbody tr:hover {
        background-color: #f2f2f2;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.9rem;
    }

    .status-badge.belum-dibaca {
        background-color: #ffcccb;
        color: #721c24;
    }

    .status-badge.sudah-dibaca {
        background-color: #d4edda;
        color: #155724;
    }

    .btn-info a {
        color: white;
        text-decoration: none;
    }

    .btn-info a:hover {
        text-decoration: underline;
    }

    .table-container {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-center text-primary">Daftar Pesan Masuk</h3>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($pesanMasuk->isEmpty())
        <div class="text-center">
            <img src="https://via.placeholder.com/150?text=No+Messages" alt="No Messages" class="mb-3">
            <p class="text-muted">Tidak ada pesan masuk saat ini.</p>
        </div>
    @else
        <div class="table-container">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Dari</th>
                        <th>Judul Pesan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanMasuk as $index => $pesan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <i class="fas fa-user-circle text-primary"></i>
                                {{ $pesan->pengirim->username ?? 'Tidak Diketahui' }}
                            </td>
                            <td>{{ $pesan->judul ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $pesan->is_read == 0 ? 'belum-dibaca' : 'sudah-dibaca' }}">
                                    {{ $pesan->is_read == 0 ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.pesan.show', $pesan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Isi
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
