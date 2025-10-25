@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Laporan Presensi</h3>

    <div class="row mb-4">
        {{-- [PERBAIKAN] Mengubah layout grid menjadi 6 kolom --}}
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>{{ $stats['total'] ?? 0 }}</h4>
                    <p>Total Record</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>{{ $stats['hadir'] ?? 0 }}</h4>
                    <p>Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-warning text-dark"> {{-- Warna text diubah agar terbaca --}}
                <div class="card-body">
                    <h4>{{ $stats['terlambat'] ?? 0 }}</h4>
                    <p>Terlambat</p>
                </div>
            </div>
        </div>
        {{-- [BARU] Card untuk Sakit --}}
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-warning text-dark"> {{-- Warna text diubah agar terbaca --}}
                <div class="card-body">
                    {{-- Pastikan controller mengirim $stats['sakit'] --}}
                    <h4>{{ $stats['sakit'] ?? 0 }}</h4>
                    <p>Sakit</p>
                </div>
            </div>
        </div>
        {{-- [BARU] Card untuk Izin --}}
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                     {{-- Pastikan controller mengirim $stats['izin'] --}}
                    <h4>{{ $stats['izin'] ?? 0 }}</h4>
                    <p>Izin</p>
                </div>
            </div>
        </div>
        {{-- [PERBAIKAN] Mengganti Tidak Hadir menjadi Alpa --}}
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    {{-- Pastikan controller mengirim $stats['alpa'] atau $stats['tidak_hadir'] --}}
                    <h4>{{ $stats['alpa'] ?? ($stats['tidak_hadir'] ?? 0) }}</h4>
                    <p>Alpa</p>
                </div>
            </div>
        </div>
    </div>
    {{-- Akhir Perubahan Statistik --}}

<div class="mb-3 text-end">
    <a href="{{ route('admin.presensi.export.excel', request()->query()) }}" class="btn btn-success btn-sm">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>
    <a href="{{ route('admin.presensi.export.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>
</div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-2">
            <label>Kelas</label>
            <select name="kelas_id" class="form-select">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Mapel</label>
            <select name="mapel_id" class="form-select">
                <option value="">Semua Mapel</option>
                @foreach ($mapels as $m)
                    <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Guru</label>
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
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>

        <div class="col-md-2">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>

        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $i => $r)
                            <tr>
                                <td>{{ $records->firstItem() + $i }}</td>
                                <td>{{ $r->siswa->username ?? '-' }}</td>
                                <td>{{ $r->presensiSession->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $r->presensiSession->mapel->nama_mapel ?? '-' }}</td>
                                <td>{{ $r->presensiSession->guru->username ?? '-' }}</td>
                                <td>{{ $r->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge
                                        @if($r->status == 'hadir') bg-success
                                        @elseif($r->status == 'terlambat') bg-warning
                                        @elseif($r->status == 'sakit') bg-warning text-dark
                                        @elseif($r->status == 'izin') bg-info
                                        @else bg-danger @endif">
                                        {{ $r->status == 'tidak_hadir' ? 'ALPA' : strtoupper($r->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $records->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
</div>

@endsection