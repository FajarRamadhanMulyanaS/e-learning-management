{{-- 
File ini HANYA untuk export excel. 
JANGAN tambahkan @include layout/header/footer/side 
--}}

<h3 style="font-weight: bold;">Detail Laporan: {{ $mapel->nama_mapel }}</h3>
<h6>Kelas: {{ $kelas->nama_kelas }}</h6>
<br>

<table border="1"> {{-- Excel lebih suka style inline atau atribut 'border' --}}
    <thead>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <th>No</th>
            <th>ID Pelajar</th>
            <th>Nama Pelajar</th>
            <th>Rata2 Tugas</th>
            <th>Rata2 Ujian</th>
            <th>Rata2 Quiz</th>
            <th>Rata2 Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($daftarSiswa as $siswa)
            @if ($siswa->user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->user->username }}</td>
                    <td>{{ $siswa->avgTugas ?? 0 }}</td>
                    <td>{{ $siswa->avgUjian ?? 0 }}</td>
                    <td>{{ $siswa->avgQuiz ?? 0 }}</td>
                    <td><strong>{{ $siswa->avgTotal ?? 0 }}</strong></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>