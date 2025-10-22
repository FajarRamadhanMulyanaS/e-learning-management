@include('layout_new.header')
@include('layout_new.side')

<div class="row">
  <div class="col-md-12 grid-margin">
    <h3 class="font-weight-bold">Daftar Mapel - Kelas: {{ $kelas->nama_kelas ?? '-' }}</h3>
  </div>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Mata Pelajaran di Kelas {{ $kelas->nama_kelas ?? '-' }}</h4>

        <div class="list-group">
          @forelse ($daftarGuruMapel as $gm) {{-- pastikan nama $gm konsisten --}}
            {{-- Pastikan relasi mapel dan user ada sebelum mengakses property --}}
            @php
              $mapel = $gm->mapel ?? null;
              $guru  = $gm->user ?? null;
            @endphp

            <a href="{{ route('admin.laporan.showDetail', ['kelasId' => $kelas->id, 'mapelId' => $mapel->id ?? 0]) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-1">{{ $mapel->nama_mapel ?? 'Mapel tidak diketahui' }}</h5>
                <small>Guru: {{ $guru->username ?? $guru->name ?? 'Belum ditentukan' }}</small>
              </div>
              <span class="badge bg-primary rounded-pill">
                Lihat Laporan
              </span>
            </a>
          @empty
            <div class="alert alert-warning text-center m-2">
              Tidak ada mata pelajaran untuk kelas ini.
            </div>
          @endforelse
        </div>

      </div>
    </div>
  </div>
</div>

@include('layout_new.footer')
