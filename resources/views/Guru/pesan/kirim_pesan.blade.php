@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <h3 class="mb-4">Manajemen Pesan</h3>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guru.pesan.index') }}">Pesan Masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Pesan Terkirim</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('guru.pesan.create') }}">Kirim Pesan</a>
        </li>
    </ul>

    <!-- Tabel Pesan Terkirim -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Pesan Keluar</strong>
        </div>
        <div class="card-body">
            @if($pesanTerkirim->isEmpty())
                <p class="text-center">Tidak ada pesan terkirim.</p>
            @else
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kepada</th>
                            <th>Isi Pesan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanTerkirim as $index => $pesan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pesan->penerima->username }}</td>
                                <td>{{ Str::limit($pesan->isi_pesan, 50) }}</td>
                                <td>{{ $pesan->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <!-- Tombol Lihat -->
                                    <button class="btn btn-info btn-sm" >
                                        <a href="{{ route('guru.pesan.show2', $pesan->id) }}"><i class="fas fa-eye"></i> Lihat </a>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('pesan.destroy', $pesan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
