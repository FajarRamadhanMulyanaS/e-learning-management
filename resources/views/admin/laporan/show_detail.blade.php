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
                <div class="justify-content-end d-flex gap-2">
                    <button onclick="window.history.back()" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>

                    <a href="{{ route('admin.laporan.exportExcel', ['kelas' => $kelas->id, 'mapel' => $mapel->id]) }}" class="btn btn-info text-white">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
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
                        <button class="nav-link active" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button" role="tab" aria-controls="nilai" aria-selected="true">
                            Laporan Nilai
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="laporanTabContent">
                    <div class="tab-pane fade show active" id="nilai" role="tabpanel" aria-labelledby="nilai-tab">
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout_new.footer')