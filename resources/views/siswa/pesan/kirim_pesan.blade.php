@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <h3 class="mb-4">Manajemen Pesan</h3>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pesan.index') }}">Pesan Masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Pesan Terkirim</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('pesan.create') }}">Kirim Pesan</a>
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
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanTerkirim as $index => $pesan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pesan->penerima->username }}</td>
                                <td>{{ $pesan->judul }}</td>
                                <td>{{ $pesan->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('siswa.pesan.show2', $pesan->id) }}" class="btn btn-info btn-sm" ><i class="fas fa-eye"></i> Lihat </a>
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

                            <!-- Modal Lihat Pesan -->
                            <div class="modal fade" id="lihatPesanModal{{ $pesan->id }}" tabindex="-1" role="dialog" aria-labelledby="lihatPesanModalLabel{{ $pesan->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="lihatPesanModalLabel{{ $pesan->id }}">Detail Pesan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Kepada:</strong> {{ $pesan->penerima->username }}</p>
                                            <p><strong>Tanggal:</strong> {{ $pesan->created_at->format('d M Y H:i') }}</p>
                                            <p><strong>Isi Pesan:</strong></p>
                                            <p>{{ $pesan->isi_pesan }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
