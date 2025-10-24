@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Presensi</h3>
        <a href="{{ route('admin.presensi.sessions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>


    <div class="card mb-4 shadow-sm">
        
        <div class="card-body">
            <h5 class="mb-3">Informasi Sesi</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($session->tanggal)->format('d/m/Y') }}</li>
                <li class="list-group-item"><strong>Guru:</strong> {{ $session->guru->username ?? '-' }}</li>
                <li class="list-group-item"><strong>Mata Pelajaran:</strong> {{ $session->mapel->nama_mapel ?? '-' }}</li>
                <li class="list-group-item"><strong>Kelas:</strong> {{ $session->kelas->nama_kelas ?? '-' }}</li>
                <li class="list-group-item"><strong>Jam Mulai:</strong> {{ \Carbon\Carbon::parse($session->jam_mulai)->format('H:i') }}</li>
                <li class="list-group-item"><strong>Mode:</strong>
                    <span class="badge {{ $session->mode == 'qr' ? 'bg-info' : 'bg-warning' }}">
                        {{ strtoupper($session->mode) }}
                    </span>
                </li>
            </ul>

            {{-- Deskripsi Sesi --}}
            <div class="p-3 border rounded bg-light">
                <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Deskripsi</h6>
                <p class="mb-0 text-muted">
                    {{ $session->deskripsi ?? 'Belum ada deskripsi untuk sesi ini.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Daftar Siswa</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.presensi.detail.export', ['id' => $session->id, 'format' => 'excel']) }}" class="btn btn-success btn-sm me-2">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>
    <a href="{{ route('admin.presensi.detail.export', ['id' => $session->id, 'format' => 'pdf']) }}" class="btn btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>
</div>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Waktu Absen</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($session->presensiRecords as $index => $record)
                            @php
                                $status = strtolower(trim($record->status));
                                $badgeClass = match($status) {
                                    'hadir' => 'bg-success',
                                    'terlambat' => 'bg-warning text-dark',
                                    'tidak_hadir' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $record->siswa->username ?? '-' }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ ucfirst($record->status ?? 'Tidak Hadir') }}</span></td>
                                <td>{{ $record->waktu_absen ? \Carbon\Carbon::parse($record->waktu_absen)->format('H:i') : '-' }}</td>
                                <td>{{ strtoupper($record->metode_absen ?? '-') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle"></i> Tidak ada data siswa untuk sesi ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
