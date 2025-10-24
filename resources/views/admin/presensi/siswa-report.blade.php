@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Laporan Presensi Siswa: {{ $siswa->username }}</h3>

    <div class="mb-3">
        <strong>Total:</strong> {{ $stats['total_records'] }} |
        <strong>Hadir:</strong> {{ $stats['hadir'] }} |
        <strong>Terlambat:</strong> {{ $stats['terlambat'] }} |
        <strong>Tidak Hadir:</strong> {{ $stats['tidak_hadir'] }} |
        <strong>Persentase Hadir:</strong> {{ $stats['persentase_hadir'] }}%
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td>{{ $r->created_at->format('d M Y') }}</td>
                            <td>{{ $r->presensiSession->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $r->presensiSession->guru->username ?? '-' }}</td>
                            <td>
                                <span class="badge 
                                    @if($r->status == 'hadir') bg-success
                                    @elseif($r->status == 'terlambat') bg-warning
                                    @else bg-danger @endif">
                                    {{ strtoupper($r->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $records->links() }}
        </div>
    </div>
</div>

@endsection
