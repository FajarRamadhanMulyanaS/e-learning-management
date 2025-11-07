@extends('layout2.app')

@section('konten')
    <style>
        .table-responsive {
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: #f2f5fa;
        }

        .table thead th {
            font-size: 16px;
            font-weight: 600;
            border-top: none;
            border-bottom: 3px solid #e2e8f0;
        }

        .table tbody td {
            font-size: 15px;
            font-weight: 500;
            color: #4a5568;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #e2e8f0;
        }

        .text-header {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .table-icon {
            font-size: 14px;
            color: #2b6cb0;
            margin-right: 5px;
        }
    </style>
    <title>Daftar Siswa</title>
    <div class="container mt-5">
        <div class="card-header bg-primary text-white text-center">
            <h1 class="font-weight-bold mb-0">Daftar Pelajar yang Diampu</h1>
        </div>
        <div class="table-responsive rounded">
            <table id="basic-datatables" class="display table table-striped table-hover text-center align-middle">
                <thead class="bg-primary text-white">
                    <tr>
                        <th><i class="fas fa-sort-numeric-down table-icon"></i>No</th>
                        <th><i class="fas fa-user table-icon"></i>Nama</th>
                        <th><i class="fas fa-id-card table-icon"></i>ID Pelajar</th>
                       {{--  <th><i class="fas fa-id-card table-icon"></i>NISN</th> --}}
                        <th><i class="fas fa-calendar table-icon"></i>Tanggal Lahir</th>
                        <th><i class="fas fa-school table-icon"></i>Kelas</th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @foreach ($siswa as $data)
                        <tr class="text-center">
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $data->username }}</td>
                            <td class="align-middle">{{ $data->siswa->nis ?? '-' }}</td>
                         {{--    <td class="align-middle">{{ $data->siswa->nisn ?? '-' }}</td> --}}
                            <td class="align-middle">{{ $data->siswa->tgl_lahir ?? '-' }}</td>
                            <td class="align-middle">{{ $data->siswa->kelas->nama_kelas ?? '-' }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
