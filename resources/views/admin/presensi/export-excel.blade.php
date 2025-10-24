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
