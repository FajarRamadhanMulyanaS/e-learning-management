@extends('layout_siswa.app')
@section('konten')
    <style>
        .container-fluid {
            background-color: white;
            padding: 15px;
        }

        h1 {
            font-family: Times, sans-serif;
            margin-left: 15px;
            margin-top: 20px;
            font-size: 24px;
        }

        .content {
            margin-left: 15px;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            h1 {
                font-size: 20px;
                margin-left: 10px;
            }

            .content {
                margin-left: 10px;
            }

            .card-header h5 {
                font-size: 16px;
            }

            /* Table responsive styles */
            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 8px 4px;
                white-space: nowrap;
            }

            /* Make table scrollable horizontally */
            .card-body {
                padding: 10px;
                overflow-x: auto;
            }

            /* Breadcrumb responsive */
            .breadcrumb {
                font-size: 12px;
                padding: 8px 0;
            }

            /* Adjust card spacing */
            .card {
                margin: 10px;
            }

            /* Table header adjustments */
            thead th {
                font-size: 12px;
                font-weight: 600;
            }

            /* Table body adjustments */
            tbody td {
                font-size: 11px;
            }
        }

        /* Additional responsive breakpoint for very small devices */
        @media screen and (max-width: 480px) {
            h1 {
                font-size: 18px;
            }

            .card-header h5 {
                font-size: 14px;
            }

            .table {
                font-size: 11px;
            }

            .breadcrumb {
                font-size: 11px;
            }
        }

        /* Keep table header visible while scrolling */
        .table thead th {
            position: sticky;
            top: 0;
            background: white;
            z-index: 1;
        }
    </style>

    <!-- Rest of your existing HTML code remains the same -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>JADWAL MATA PELAJARAN</h1>
                <div class="content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><span class="no-link">My courses</span></li>
                        <li class="breadcrumb-item"><a href="#">JADWAL MATA PELAJARAN</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">
                <i class="fa-solid fa-list"></i> Jadwal Kelas
                <strong>{{ $siswa->kelas->nama_kelas ?? '-' }}</strong>

            </h5>
        </div>

        <div class="card-body">
            <table class="table table-hover" id="datatablesSimple">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Jam</th>
                        <th scope="col">Mapel</th>
                        <th scope="col">Pengajar</th>
                        <th scope="col">Ruang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($jadwal ?? collect()) as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->hari ?? '-' }}</td>
                            <td>
                                {{ optional(\Illuminate\Support\Carbon::parse($item->jam_mulai ?? '00:00'))->format('H:i') }}
                                -
                                {{ optional(\Illuminate\Support\Carbon::parse($item->jam_selesai ?? '00:00'))->format('H:i') }}
                            </td>
                            <td>{{ optional($item->mapel)->nama_mapel ?? '-' }}</td>
                            <td>{{ optional($item->user)->username ?? '-' }}</td>
                            <td>{{ $item->ruang ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada jadwal untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
