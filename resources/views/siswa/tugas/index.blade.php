@extends('layout_siswa.app')

@section('konten')
    <title>Tugas</title>

    <style>
        /* Base styles */
        .container {
            padding: 15px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Table styles */
        .table {
            margin-bottom: 0;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
                margin-top: 2rem !important;
            }

            .card-header h3 {
                font-size: 1.25rem;
            }

            /* Table responsive */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                font-size: 13px;
            }

            .table th,
            .table td {
                padding: 8px 4px;
                white-space: nowrap;
            }

            /* Badge adjustments */
            .badge {
                font-size: 11px;
                padding: 4px 8px;
            }

            /* Button adjustments */
            .btn-sm {
                font-size: 12px;
                padding: 4px 8px;
            }

            .btn i {
                font-size: 11px;
            }
        }

        /* Extra small devices */
        @media screen and (max-width: 480px) {
            .container {
                padding: 5px;
            }

            .card-header h3 {
                font-size: 1.1rem;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 6px 3px;
            }

            .badge {
                font-size: 10px;
                padding: 3px 6px;
            }

            .btn-sm {
                font-size: 11px;
                padding: 3px 6px;
            }
        }
    </style>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Daftar Tugas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                            @foreach ($tugas as $item)
                                <tr
                                    class="
                            @if ($item->status == 'submitted') table-success
                            @elseif($item->status == 'overdue') table-danger
                            @else table-warning @endif
                        ">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->mapel->nama_mapel ?? 'Tidak ada' }}</td>
                                    <td>
                                        @if ($item->tanggal_pengumpulan)
                                            {{ $item->tanggal_pengumpulan->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'submitted')
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
                                        <a href="{{ route('siswa.tugas.show', $item->id) }}"
                                            class="btn btn-info btn-sm text-white">
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
    </div>
@endsection
