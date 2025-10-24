<table>
    <thead>
        <tr>
            <th colspan="5" style="text-align:center; font-weight:bold;">Laporan Presensi Sesi</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Guru</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Mode</th>
        </tr>
        <tr>
            <td>{{ \Carbon\Carbon::parse($session->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $session->guru->username ?? '-' }}</td>
            <td>{{ $session->mapel->nama_mapel ?? '-' }}</td>
            <td>{{ $session->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ strtoupper($session->mode) }}</td>
        </tr>
    </thead>
</table>

<br>

<table border="1">
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
