@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3 class="mb-3">Manajemen Sesi Presensi</h3>

    <!-- Filter -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Guru</label>
            <select name="guru_id" class="form-select">
                <option value="">Semua Guru</option>
                @foreach ($gurus as $g)
                    <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                        {{ $g->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>

        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Filter
            </button>
        </div>
    </form>

    <!-- Tombol Export -->
    <div class="mb-3 text-end">
        <a href="{{ route('admin.presensi.export', ['format' => 'excel']) }}" class="btn btn-success btn-sm me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.presensi.export', ['format' => 'pdf']) }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    <!-- Tabel Sesi Presensi -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Semua Sesi Presensi</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Jam Mulai</th>
                            <th>Mode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $i => $session)
                            <tr>
                                <td class="text-center">{{ $sessions->firstItem() + $i }}</td>
                                <td>{{ \Carbon\Carbon::parse($session->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $session->guru->username ?? '-' }}</td>
                                <td>{{ $session->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $session->kelas->nama_kelas ?? '-' }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($session->jam_mulai)->format('H:i') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $session->mode == 'qr' ? 'bg-info' : 'bg-warning' }}">
                                        {{ strtoupper($session->mode) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($session->is_closed)
                                        <span class="badge bg-secondary">Selesai</span>
                                    @elseif($session->is_active)
                                        <span class="badge bg-success">Berjalan</span>
                                    @else
                                        <span class="badge bg-warning">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.presensi.kelas-report', $session->kelas_id) }}" 
                                       class="btn btn-sm btn-primary mb-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>

                                    @if($session->is_active && !$session->is_closed)
                                        <form action="{{ route('admin.presensi.close', $session->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Tutup sesi presensi ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-times"></i> Tutup Presensi
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle"></i> Tidak ada data sesi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</div>
  <script>
        function closeSession(id) {
            if (confirm('Apakah Anda yakin ingin menutup sesi ini?')) {
                fetch(`/admin/presensi/close/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message || 'Sesi berhasil ditutup');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat menutup sesi');
                });
            }
        }
    </script>
@endsection
