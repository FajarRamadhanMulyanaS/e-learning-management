<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Presensi Siswa</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $r->siswa->nis ?? '-' }}</td>
                <td>{{ $r->siswa->name ?? '-' }}</td>
                <td>{{ $r->presensiSession->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $r->presensiSession->guru->name ?? '-' }}</td>
                <td>{{ $r->presensiSession->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $r->presensiSession->tanggal ?? '-' }}</td>
                <td>{{ ucfirst($r->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
