<table>
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nilai PG</th>
            <th>Nilai Essay</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswaSudahUjian as $siswa)
            <tr>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nama_siswa }}</td>
                <td>{{ $siswa->kelas }}</td>
                <td>{{ $siswa->nilai_pg ?? 'N/A' }}</td>
                <td>{{ $siswa->total_nilai_essay ?? 'N/A' }}</td>
                <td>{{ $siswa->jumlah }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nilai PG</th>
            <th>Nilai Essay</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswaSudahUjian as $siswa)
            <tr>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nama_siswa }}</td>
                <td>{{ $siswa->kelas }}</td>
                <td>{{ $siswa->nilai_pg ?? 'N/A' }}</td>
                <td>{{ $siswa->total_nilai_essay ?? 'N/A' }}</td>
                <td>{{ $siswa->jumlah }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
