<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Presensi</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelajar</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Pengajar</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->siswa->username ?? '-' }}</td>
                    <td>{{ $r->presensiSession->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $r->presensiSession->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $r->presensiSession->guru->username ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->presensiSession->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($r->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
