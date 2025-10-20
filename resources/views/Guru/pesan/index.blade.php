@extends('layout2.app')

@section('konten')

<style>
    .table-container {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
        text-transform: uppercase;
        font-weight: bold;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        font-size: 0.9rem;
        border-radius: 20px;
        color: #fff;
    }

    .status-badge.belum-dibaca {
        background-color: #dc3545;
    }

    .status-badge.sudah-dibaca {
        background-color: #28a745;
    }

    .btn-info a {
        color: #fff;
        text-decoration: none;
    }

    .btn-info a:hover {
        text-decoration: underline;
    }

    .no-messages {
        text-align: center;
        padding: 50px 20px;
        font-size: 1.2rem;
        color: #6c757d;
    }

    .no-messages img {
        max-width: 150px;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-center text-primary">Daftar Pesan Masuk</h3>

    <div class="table-container">
        @if($pesanMasuk->isEmpty())
            <div class="no-messages">
                <img src="https://via.placeholder.com/150?text=No+Messages" alt="No Messages">
                <p>Belum ada pesan masuk.</p>
            </div>
        @else
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
                            <td><i class="fas fa-user-circle text-primary"></i> {{ $pesan->pengirim->username }}</td>
                            <td>{{ $pesan->judul }}</td>
                            <td>
                                <span class="status-badge {{ $pesan->is_read == 0 ? 'belum-dibaca' : 'sudah-dibaca' }}">
                                    {{ $pesan->is_read == 0 ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('guru.pesan.show', $pesan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Isi
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
