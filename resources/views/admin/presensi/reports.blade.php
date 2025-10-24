@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Laporan Presensi</h3>

    <!-- Statistik Umum -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>{{ $stats['total'] }}</h4>
                    <p>Total Record</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>{{ $stats['hadir'] }}</h4>
                    <p>Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>{{ $stats['terlambat'] }}</h4>
                    <p>Terlambat</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>{{ $stats['tidak_hadir'] }}</h4>
                    <p>Tidak Hadir</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
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
        <div class="col-md-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>
        <div class="col-md-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Filter</button>
        </div>
    </form>

    <!-- Tabel Laporan -->
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
                                        @else bg-danger @endif">
                                        {{ strtoupper($r->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $records->links() }}
        </div>
    </div>
</div>

@endsection
