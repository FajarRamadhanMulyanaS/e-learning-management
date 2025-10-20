@extends('layout2.app')

@section('konten')
<div class="container">
    <h3 class="my-4">Menu Manajemen Ujian / Tugas</h3>

    <div class="card">
        <div class="card-header">
            Detail Soal Ujian / Tugas
            <a href="{{route('guru.manajemen-ujian.index')}}" class="btn btn-secondary float-right">Back</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Judul Tugas/Ujian</th>
                    <td>{{ $ujian->judul }}</td>
                </tr>
                <tr>
                    <th>Kelas Yang Ditugaskan</th>
                    <td>{{ $ujian->kelas->nama_kelas }}</td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $ujian->mapel->nama_mapel }}</td>
                </tr>
                <tr>
                    <th>Jenis Soal</th>
                    <td>{{ $ujian->info_ujian }}</td>
                </tr>
                <tr>
                    <th>Waktu Pengerjaan</th>
                    <td>{{ $ujian->waktu_pengerjaan }} Menit</td>
                </tr>
            </table>

            <!-- Tombol untuk melihat soal -->
            <div class="d-flex justify-content-center my-3">
                <a href="{{ route('guru.manajemen-ujian.essay', $ujian->id) }}" class="btn btn-success mx-2">Soal Essay</a>
                <a href="{{ route('guru.manajemen-ujian.pilihan-ganda', $ujian->id) }}" class="btn btn-primary mx-2">Pilihan Ganda</a>
            </div>
        </div>
    </div>
</div>
@endsection
