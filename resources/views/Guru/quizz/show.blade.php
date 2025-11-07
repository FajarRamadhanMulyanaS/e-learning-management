@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Kuis: {{ $quiz->judul }}</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">
                {{ $quiz->guruMapel->mapel->nama_mapel }} - Kelas {{ $quiz->guruMapel->kelas->nama_kelas }}
            </p>
            <hr>
            <h5 class="font-weight-bold">Deskripsi / Petunjuk</h5>
            <p>{!! nl2br(e($quiz->description ?? 'Tidak ada deskripsi.')) !!}</p> {{-- Tambah null safety --}}

            {{-- Tampilkan Lampiran Jika Ada --}}
            @if($quiz->attachment_file)
                <p><strong>Lampiran File:</strong> <a href="{{ Storage::url($quiz->attachment_file) }}" target="_blank">Unduh File</a></p>
            @endif
            @if($quiz->attachment_link)
                <p><strong>Lampiran Link:</strong> <a href="{{ $quiz->attachment_link }}" target="_blank">{{ $quiz->attachment_link }}</a></p>
            @endif
             @if($quiz->attachment_image)
                <p><strong>Lampiran Gambar:</strong></p>
                <img src="{{ Storage::url($quiz->attachment_image) }}" alt="Lampiran Gambar" style="max-width: 100%; height: auto; border-radius: 8px;">
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Jawaban Pelajar</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="basic-datatables"> {{-- Tambahkan ID untuk datatables jika perlu --}}
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelajar</th>
                            <th>Waktu Mengumpulkan</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- !! PERBAIKAN DI SINI: Ganti $students menjadi $siswaDiKelas !! --}}
                        @forelse($siswaDiKelas as $userSiswa) {{-- Ganti nama variabel loop agar lebih jelas --}}
                            @php
                                // Akses submission dari relasi siswa yang sudah di-load
                                // Gunakan first() karena kita hanya load satu submission per siswa untuk quiz ini
                                $submission = $userSiswa->siswa->quizSubmissions->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $userSiswa->username }}</td> {{-- Nama dari User --}}
                                <td>{{ $submission ? $submission->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    @if($submission)
                                        <span class="badge bg-success">Sudah Mengerjakan</span> {{-- Ganti badge-success -> bg-success (Bootstrap 5) --}}
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Mengerjakan</span> {{-- Ganti badge-warning -> bg-warning text-dark --}}
                                    @endif
                                </td>
                                <td><strong>{{ $submission->nilai ?? '-' }}</strong></td>
                                <td class="text-center">
                                    @if($submission)
                                        <a href="{{ route('guru.quiz.grade', $submission->id) }}" class="btn btn-sm btn-info">Lihat & Nilai</a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Belum Ada Jawaban</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada siswa di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('guru.quiz.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kuis</a>
</div>
@endsection
