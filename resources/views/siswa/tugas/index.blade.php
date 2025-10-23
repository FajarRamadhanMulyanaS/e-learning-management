@extends('layout_siswa.app')

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
                        <th scope="col">Deadline</th>
                        <th scope="col">Status</th>
                        <th scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tugas as $item)
                    <tr class="
                        @if($item->status == 'submitted') table-success
                        @elseif($item->status == 'overdue') table-danger
                        @else table-warning
                        @endif
                    ">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->mapel->nama_mapel ?? 'Tidak ada' }}</td>
                        <td>
                            @if($item->tanggal_pengumpulan)
                                {{ $item->tanggal_pengumpulan->format('d-m-Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($item->status == 'submitted')
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Sudah Disubmit
                                </span>
                            @elseif($item->status == 'overdue')
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Melebihi Deadline
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> Belum Disubmit
                                </span>
                            @endif
                        </td>
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
