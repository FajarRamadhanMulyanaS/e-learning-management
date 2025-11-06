@include('layout_new.header')
@include('layout_new.side')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Laporan Kelas: {{ $kelas->nama_kelas }}</h3>
                <h6 class="font-weight-normal mb-0">Langkah 2: Pilih mata pelajaran untuk melihat detail laporan.</h6>
            </div>
             <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <button onclick="window.history.back()" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
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
                <h4 class="card-title">Daftar Mata Pelajaran</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>pengajar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- !! KODE DIBAWAH INI BERUBAH !! --}}
                            @forelse ($daftarGuruMapel as $gm)
                                <tr>
                                    <td>{{ $gm->mapel->nama_mapel ?? 'Mapel tidak ada' }}</td>
                                    <td>{{ $gm->user->username ?? 'Guru tidak ada' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.laporan.showDetail', [$kelas->id, $gm->mapel_id]) }}" class="btn btn-primary btn-sm">
                                            Lihat Laporan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada mata pelajaran yang diajarkan di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout_new.footer')