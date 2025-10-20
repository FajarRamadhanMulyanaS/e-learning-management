@extends('layout2.app')

@section('konten')
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
                    <td>: {{ $ujian->guru->user->username ?? 'Tidak Ada' }}</td>
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
