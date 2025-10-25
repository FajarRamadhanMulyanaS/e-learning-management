<table>
    <thead>
        <tr>
            {{-- [PERBAIKAN] Colspan diubah dari 5 menjadi 4 --}}
            <th colspan="4" style="text-align:center; font-weight:bold;">Laporan Presensi Sesi</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Guru</th>
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            {{-- [PERBAIKAN] Kolom 'Mode' dihapus --}}
        </tr>
        <tr>
            <td>{{ \Carbon\Carbon::parse($session->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $session->guru->username ?? '-' }}</td>
            <td>{{ $session->mapel->nama_mapel ?? '-' }}</td>
            <td>{{ $session->kelas->nama_kelas ?? '-' }}</td>
            {{-- [PERBAIKAN] Sel <td> 'Mode' dihapus --}}
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
            {{-- [PERBAIKAN] Kolom 'Metode' dihapus --}}
        </tr>
    </thead>
    <tbody>
        @foreach($session->presensiRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->siswa->username ?? '-' }}</td>
                <td>{{ $record->status ?? 'Tidak Hadir' }}</td>
                <td>{{ $record->waktu_absen ? \Carbon\Carbon::parse($record->waktu_absen)->format('H:i') : '-' }}</td>
                {{-- [PERBAIKAN] Sel <td> 'Metode' dihapus --}}
            </tr>
        @endforeach
    </tbody>
</table>