@extends('layout_siswa.app')

@section('konten')
<div class="container mt-5">
    <!-- Title Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Hasil Ujian: {{ $ujian->judul }}</h3>
        </div>
    </div>

    <!-- Score Section -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <h5 class="card-title">Skor Anda: <span class="text-success">{{ $skor }}</span></h5>
            <p><strong>Total Soal:</strong> {{ $totalSoal }}</p>
            <p><strong>Jawaban Benar:</strong> {{ $jumlahBenar }}</p>
        </div>
    </div>

    <!-- Detail Jawaban Pilihan Ganda -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Detail Jawaban Pilihan Ganda</h5>

            <table class="table table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Jawaban Siswa</th>
                        <th>Jawaban Benar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ujian->pilihanGanda as $index => $soal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $soal->soal }}</td>
                            <td>{{ $jawabanSiswa[$soal->id] ?? 'Tidak Dijawab' }}</td>
                            <td>{{ $soal->kunci_jawaban }}</td>
                            <td>
                                @if (isset($jawabanSiswa[$soal->id]) && $jawabanSiswa[$soal->id] == $soal->kunci_jawaban)
                                    <span class="badge bg-success">Benar</span>
                                @else
                                    <span class="badge bg-danger">Salah</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('siswa.ujian.kerjakan', ['ujian_id' => $ujian->id]) }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Ujian
        </a>
    </div>
</div>
@endsection
