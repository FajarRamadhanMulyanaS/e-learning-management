@extends('layout_siswa.app')

@section('konten')
<style>
    /* Base styles */
    .container {
        padding: 15px;
    }

    .card {
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .card-header h3 {
        margin: 0;
        font-size: 24px;
    }

    /* Table styles */
    .table {
        margin-bottom: 0;
    }

    .table th {
        width: 35%;
        background-color: #f8f9fa;
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .container {
            padding: 10px;
        }

        .card-header h3 {
            font-size: 20px;
        }

        .card-title {
            font-size: 18px;
        }

        /* Table responsive */
        .table {
            font-size: 13px;
        }

        .table th, 
        .table td {
            padding: 8px;
        }

        /* Button adjustments */
        .btn {
            font-size: 14px;
            padding: 8px 16px;
        }

        .btn i {
            font-size: 12px;
        }

        /* Stack columns on mobile */
        .col-md-6 {
            margin-bottom: 15px;
        }
    }

    /* Small mobile devices */
    @media screen and (max-width: 480px) {
        .container {
            padding: 5px;
        }

        .card-header h3 {
            font-size: 18px;
        }

        .card-title {
            font-size: 16px;
        }

        /* Smaller table text */
        .table {
            font-size: 12px;
        }

        .table th, 
        .table td {
            padding: 6px;
        }

        /* Adjust button size */
        .btn {
            font-size: 13px;
            padding: 6px 12px;
        }

        .btn i {
            font-size: 11px;
        }

        /* Make table scrollable if needed */
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<div class="container mt-5">
    <!-- Title Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Informasi Ujian/Tugas</h3>
        </div>
    </div>

    <!-- Ujian Info Section -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Ujian Online</h5>

            <a href="{{ route('siswa.ujian.view', ['id' => $ujian->id]) }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Nama Ujian</th>
                        <td>: {{ $ujian->judul }}</td>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <td>: {{ $ujian->mapel->nama_mapel ?? 'Tidak Ada' }}</td>
                    </tr>
                    <tr>
                        <th>Pengajar</th>
                        <td>: {{ $ujian->user->username ?? 'Tidak Ada' }}</td>
                    </tr>
                    <tr>
                        <th>Batas Waktu Ujian</th>
                        <td>: {{ $ujian->waktu_pengerjaan }} Menit</td>
                    </tr>
                    <tr>
                        <th>Status Soal Pilihan Ganda</th>
                        <td>
                            @if ($ujian->pilihanGanda->count() > 0)
                                : Ada {{ $ujian->pilihanGanda->count() }} Soal Pilihan Ganda
                            @else
                                : Tidak Ada Soal Pilihan Ganda
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status Soal Essay</th>
                        <td>
                            @if ($ujian->essay->count() > 0)
                                : Ada {{ $ujian->essay->count() }} Soal Essay
                            @else
                                : Tidak Ada Soal Essay
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Action Section for Pilihan Ganda and Essay -->
    <div class="row">
        <!-- Pilihan Ganda Section -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Pilihan Ganda</h5>
                    @if ($ujian->pilihanGanda->count() > 0)
                        @if ($siswa->hasCompletedPilihanGanda($ujian->id))
                            <a href="{{ route('siswa.ujian.nilai.pilgan', $ujian->id) }}" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Melihat Nilai
                            </a>
                        @else
                            <a href="{{ route('siswa.ujian.mulai.pilgan', $ujian->id) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-play"></i> Mulai Kerjakan
                            </a>
                        @endif
                    @else
                        <button class="btn btn-secondary btn-block" disabled>Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Essay Section -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Essay</h5>
                    @if ($ujian->essay->count() > 0)
                        @if ($siswa->hasCompletedEssay($ujian->id))
                            <a href="{{ route('siswa.ujian.nilai.essay', $ujian->id) }}" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Melihat Nilai
                            </a>
                        @else
                            <a href="{{ route('siswa.ujian.mulai.essay', $ujian->id) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-play"></i> Mulai Kerjakan
                            </a>
                        @endif
                    @else
                        <button class="btn btn-secondary btn-block" disabled>Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
