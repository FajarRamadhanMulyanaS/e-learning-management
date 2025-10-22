@extends('layout2.app')

@section('konten')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-book-open mr-2"></i> Detail Tugas</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-file-alt mr-2"></i> Judul Tugas</h5>
                        <p class="text-muted">{{ $tugas->judul }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-book mr-2"></i> Mata Pelajaran</h5>
                        <p class="text-muted">{{ $tugas->mapel->nama_mapel ?? 'Tidak ada' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-chalkboard-teacher mr-2"></i> Guru</h5>
                        <p class="text-muted">{{ $tugas->guru->username ?? 'Tidak ada' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-users mr-2"></i> Kelas</h5>
                        <p class="text-muted">{{ $tugas->kelas->nama_kelas ?? 'Tidak ada' }}</p>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-align-left mr-2"></i> Deskripsi</h5>
                        <p class="text-muted">{{ $tugas->deskripsi }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-calendar-alt mr-2"></i> Tanggal Pengumpulan</h5>
                        <p class="text-muted">{{ $tugas->tanggal_pengumpulan ? $tugas->tanggal_pengumpulan->format('d-m-Y') : 'Tidak ada' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-primary"><i class="fas fa-paperclip mr-2"></i> File Tugas</h5>
                        @if($tugas->file)
                            <a href="{{ asset('storage/' . $tugas->file) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-download mr-2"></i> Lihat File
                            </a>
                        @else
                            <p class="text-muted">Tidak ada file</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tombol Menuju Halaman Pengumpulan Tugas -->
            <div class="mt-4 text-center">
                <a href="{{ route('siswa.tugas.submit', $tugas->id) }}" class="btn btn-success">
                    <i class="fas fa-upload mr-2"></i> Pengumpulan Tugas
                </a>
            </div>

            <!-- Tabel Pengumpulan Tugas -->
            <div class="mt-5">
                <h4 class="text-primary text-center"><i class="fas fa-list mr-2"></i> Tabel Pengumpulan Tugas</h4>
                <!-- Tambahkan table-responsive di sini -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-4">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>File Tugas</th>
                                <th>Komentar</th>
                                <th>Tanggal Pengumpulan</th>
                                <th>Nilai</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengumpulanTugas as $pengumpulan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengumpulan->siswa->user->username ?? 'Siswa tidak ditemukan' }}</td>
                                    <td>
                                        @if($pengumpulan->file_tugas)
                                            <a href="{{ asset('storage/' . $pengumpulan->file_tugas) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengumpulan->komentar ?? '-' }}</td>
                                    <td>{{ $pengumpulan->created_at ? $pengumpulan->created_at->format('d-m-Y H:i') : '-' }}</td>
                                    <td>
                                        @if ($pengumpulan->nilai !== null && $pengumpulan->nilai !== 0)
                                            <span>{{ $pengumpulan->nilai }}</span>
                                        @else
                                            <span>belum dinilai</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pengumpulan->siswa_id == $siswaId)
                                            <a href="{{ route('siswa.tugas.edit', $pengumpulan->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('siswa.tugas.destroyTugasSiswa', $pengumpulan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus kiriman tugas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            {{-- Jika bukan pemilik, jangan tampilkan tombol apa pun (cukup tanda strip) --}}
                                            <span>-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 text-center">
                <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
