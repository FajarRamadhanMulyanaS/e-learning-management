@extends('layout_new.app')


@section('konten')


<div class="container mt-4">
    <h3>Buat Sesi Presensi</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.presensi.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">- Pilih Kelas -</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                            <option value="">- Pilih Mapel -</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Semester</label>
                        <select name="semester_id" class="form-select">
                            <option value="">- Opsional -</option>
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_semester }} {{ $s->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" 
                               value="{{ date('Y-m-d') }}" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" 
                               value="{{ date('H:i') }}" required />
                        <small class="text-muted">Status terlambat jika absen melewati jam ini</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mode Presensi</label>
                        <select name="mode" class="form-select" required>
                            <option value="">- Pilih Mode -</option>
                            <option value="qr">QR Code</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3" 
                                  placeholder="Contoh: Pertemuan ke-1, Materi Pengenalan..."></textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Buat Sesi Presensi
                    </button>
                    <a href="{{ route('guru.presensi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
