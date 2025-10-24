<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h3 { text-align: center; }
    </style>
</head>
<body>
    <h3>Laporan Presensi Sesi</h3>

    <table>
        <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($session->tanggal)->format('d/m/Y') }}</td></tr>
        <tr><th>Guru</th><td>{{ $session->guru->username ?? '-' }}</td></tr>
        <tr><th>Mata Pelajaran</th><td>{{ $session->mapel->nama_mapel ?? '-' }}</td></tr>
        <tr><th>Kelas</th><td>{{ $session->kelas->nama_kelas ?? '-' }}</td></tr>
        <tr><th>Mode</th><td>{{ strtoupper($session->mode) }}</td></tr>
    </table>

    <h4>Daftar Siswa</h4>
    <table>
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
            @foreach($session->presensiRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->siswa->username ?? '-' }}</td>
                <td>{{ $record->status ?? 'Tidak Hadir' }}</td>
                <td>{{ $record->waktu_absen ? \Carbon\Carbon::parse($record->waktu_absen)->format('H:i') : '-' }}</td>
                <td>{{ strtoupper($record->metode_absen ?? '-') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
