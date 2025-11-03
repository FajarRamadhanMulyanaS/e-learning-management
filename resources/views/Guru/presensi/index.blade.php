@extends('layout2.app')

@section('konten')
<style>
    /* Mobile Optimization */
    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Manajemen Presensi</h3>
        <a href="{{ route('guru.presensi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Sesi Presensi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Sesi Presensi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Status Sesi</th>
                            <th>Rekap Presensi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $index => $session)
                            <tr>
                                <td>{{ $sessions->firstItem() + $index }}</td>
                                <td>{{ $session->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $session->jam_mulai_formatted }}</td>
                                <td>{{ $session->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $session->mapel->nama_mapel ?? '-' }}</td>
                                <td>
                                    @if($session->is_active && !$session->is_closed)
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($session->is_closed)
                                        <span class="badge bg-secondary">Ditutup</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $stats = $session->getPresensiStats();
                                    @endphp
                                    <small class="text-muted">
                                        {{ $stats['hadir'] + $stats['terlambat'] }}/{{ $stats['total_siswa'] }} 
                                        ({{ $stats['persentase_hadir'] }}%)
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Tombol lihat detail dan ubah status siswa -->
                                        <a href="{{ route('guru.presensi.show', $session->id) }}" 
                                           class="btn btn-sm btn-info" title="Lihat & Ubah Status Siswa">
                                            <i class="fas fa-user-check"></i>
                                        </a>

                                        @if($session->is_active && !$session->is_closed)
                                            <form action="{{ route('guru.presensi.close', $session->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tutup sesi presensi ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Tutup Sesi">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada sesi presensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
