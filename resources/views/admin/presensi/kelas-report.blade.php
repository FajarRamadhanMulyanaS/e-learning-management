@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Laporan Kelas: {{ $kelas->nama_kelas }}</h3>

    <div class="mb-3">
        <strong>Total Sesi:</strong> {{ $stats['total_sessions'] }} |
        <strong>Total Record:</strong> {{ $stats['total_records'] }} |
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
                        <th>Jumlah Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $s)
                        <tr>
                            <td>{{ $s->tanggal }}</td>
                            <td>{{ $s->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $s->guru->username ?? '-' }}</td>
                            <td>{{ $s->presensiRecords->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $sessions->links() }}
        </div>
    </div>
</div>

@endsection
