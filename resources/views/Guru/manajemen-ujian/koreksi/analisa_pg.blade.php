@extends('layout2.app')

@section('konten')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <div class="card shadow mt-4 mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Analisis Jawaban Pilihan Ganda</h3>
            <h4>{{ $ujian->judul }}</h4>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h5>Data Siswa</h5>
            <table class="table table-bordered">
                <tr>
                    <th>NIS</th>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $siswa->user->username }}</td> <!-- Memperbaiki 'usernama' menjadi 'username' -->
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ optional($siswa->user->kelas)->nama_kelas ?? 'Tidak ada data kelas' }}</td>
                </tr>
            </table>

            <h5 class="mt-4">Jawaban Pilihan Ganda</h5>
            <table class="table table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Kunci</th>
                        <th>Jawaban</th>
                        <th>Analisa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ujian->soal as $index => $soal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $soal->soal }}</td>
                            <td>{{ $soal->kunci_jawaban }}</td>
                            <td>{{ $soal->jawaban_siswa }}</td> <!-- Menampilkan jawaban siswa -->
                            <td>
                                <span class="badge {{ $soal->analisa == 'Benar' ? 'bg-success' : ($soal->analisa == 'Salah' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $soal->analisa }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Section -->
            <div class="alert alert-info mt-4">
                <strong>Jumlah Soal Benar:</strong> {{ $jumlahBenar }} <br>
                <strong>Jumlah Soal Salah:</strong> {{ $jumlahSalah }} <br>
                <strong>Tidak Dijawab:</strong> {{ $tidakDijawab }}
            </div>

            <!-- Back Button -->
            <div class="text-center">
                <a href="{{ route('guru.manajemen-ujian.daftar-siswa', ['ujian_id' => $ujian->id]) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Ujian
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
