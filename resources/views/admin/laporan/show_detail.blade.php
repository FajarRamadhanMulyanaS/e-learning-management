@include('layout_new.header')
@include('layout_new.side')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Detail Laporan: {{ $mapel->nama_mapel }}</h3>
                <h6 class="font-weight-normal mb-0">Kelas: {{ $kelas->nama_kelas }}</h6>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="laporanTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button" role="tab" aria-controls="nilai" aria-selected="true">Laporan Nilai</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="presensi-tab" data-bs-toggle="tab" data-bs-target="#presensi" type="button" role="tab" aria-controls="presensi" aria-selected="false">Laporan Presensi</button>
                    </li>
                </ul>

                <div class="tab-content" id="laporanTabContent">
                    
                    <div class="tab-pane fade show active" id="nilai" role="tabpanel" aria-labelledby="nilai-tab">
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
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
                        </div>
                    </div>

                    <div class="tab-pane fade" id="presensi" role="tabpanel" aria-labelledby="presensi-tab">
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Hadir</th>
                                        <th>Terlambat</th>
                                        <th>Izin</th>
                                        <th>Sakit</th>
                                        <th>Alpa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftarSiswa as $siswa)
                                        @if ($siswa->user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>{{ $siswa->user->username }}</td>
                                            <td>{{ $siswa->totalHadir ?? 0 }}</td>
                                            <td>{{ $siswa->totalTerlambat ?? 0 }}</td>
                                            <td>{{ $siswa->totalIzin ?? 0 }}</td>
                                            <td>{{ $siswa->totalSakit ?? 0 }}</td>
                                            <td>{{ $siswa->totalAlpa ?? 0 }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout_new.footer')