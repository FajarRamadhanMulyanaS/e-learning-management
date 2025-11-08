@extends('layout_siswa.app')

@section('konten')
    <style>
        /* Base styles */
        .content-wrapper {
            margin-top: 20px;
            padding: 15px;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-weight: bold;
        }

        .card-title {
            font-weight: 600;
            color: #2b6cb0;
        }

        /* Table styles */
        .table {
            width: 100%;
            margin-bottom: 1rem;
        }

        .table thead th {
            text-align: center;
            font-weight: 600;
            background-color: #f9fafb;
            padding: 12px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 12px;
        }

        /* Button styles */
        .btn {
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .content-wrapper {
                margin-top: 10px;
                padding: 10px;
            }

            .card-header {
                padding: 12px;
            }

            .card-header h4 {
                font-size: 18px;
            }

            .card-body {
                padding: 15px;
            }

            .card-title {
                font-size: 16px;
            }

            /* Table responsive */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                font-size: 13px;
            }

            .table thead th {
                padding: 8px;
                font-size: 13px;
            }

            .table tbody td {
                padding: 8px;
                font-size: 13px;
            }

            /* Button adjustments */
            .btn {
                font-size: 13px;
                padding: 6px 12px;
            }

            /* Row spacing */
            .row {
                margin: 0 -8px;
            }

            .col-md-6 {
                padding: 0 8px;
                margin-bottom: 10px;
            }

            /* Text adjustments */
            p {
                font-size: 13px;
                margin-bottom: 8px;
            }

            strong {
                font-size: 13px;
            }
        }

        /* Small mobile devices */
        @media screen and (max-width: 480px) {
            .content-wrapper {
                padding: 5px;
            }

            .card-header h4 {
                font-size: 16px;
            }

            .card-title {
                font-size: 15px;
            }

            .table {
                font-size: 12px;
            }

            .table thead th,
            .table tbody td {
                padding: 6px;
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
                padding: 5px 10px;
            }

            p,
            strong {
                font-size: 12px;
            }
        }
    </style>

    <div class="container content-wrapper">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="m-0">📚 Modul / Materi</h4>
                  <button class="btn btn-outline-light btn-sm" onclick="window.location.href='{{ route('siswa.materi.index') }}'">⬅ Kembali</button>
            </div>
            <div class="card-body">
                <h5 class="card-title">📄 Detail Materi</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Mata Pelajaran:</strong>
                            {{ $materi->mapel->nama_mapel ?? 'Mata Pelajaran Tidak Ditemukan' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Pengajar:</strong> {{ $materi->user->username }}</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-4">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="60%">Judul Materi/Modul</th>
                                <th width="30%">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>{{ $materi->judul }}</td>
                                <td class="text-center">
                                    <a href="{{ Storage::url($materi->file_path) }}" class="btn btn-success btn-sm"
                                        download>
                                        ⬇ Download
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
