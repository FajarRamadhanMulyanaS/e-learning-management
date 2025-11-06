@include('layout_new.header')
@include('layout_new.side')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Laporan Pelajar</h3>
                <h6 class="font-weight-normal mb-0">Langkah 1: Pilih kelas yang ingin Anda lihat laporannya.</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Kelas</h4>
                <div class="list-group">
                    @forelse ($daftarKelas as $kelas)
                        <a href="{{ route('admin.laporan.showKelas', $kelas->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $kelas->nama_kelas }}</h5>
                                <small>Kode Kelas: {{ $kelas->kode_kelas }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $kelas->siswa_count }} Pelajar</span>
                        </a>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            Belum ada data kelas yang bisa ditampilkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout_new.footer')