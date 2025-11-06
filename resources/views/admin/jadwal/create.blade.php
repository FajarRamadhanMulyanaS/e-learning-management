@extends('layout_new.app')
@section('konten')

<div class="container mt-4">
    <h3>Tambah Jadwal</h3>

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
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-select" required>
                            <option value="">- Pilih -</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                            <option value="">- Pilih -</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="user_id">Pilih Pengajar</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Pilih Pengajar</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Semester</label>
                        <select name="semester_id" class="form-select">
                            <option value="">- Opsional -</option>
                            @foreach($semesters as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_semester }} {{ $s->tahun_ajaran }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-select" required>
                            <option value="">- Pilih -</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required />
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ruang</label>
                        <input type="text" name="ruang" class="form-control" placeholder="cth: R1" />
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


