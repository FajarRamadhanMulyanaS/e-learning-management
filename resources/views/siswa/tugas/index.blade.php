@extends('layout2.app')

@section('konten')
<title>Tugas</title>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Daftar Tugas</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Mata Pelajaran</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tugas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->mapel->nama_mapel ?? 'Tidak ada' }}</td>
                        <td>
                            <a href="{{ route('siswa.tugas.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
