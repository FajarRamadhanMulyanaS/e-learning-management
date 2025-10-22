@extends('layout2.app')

@section('konten')
<title>Tambah Tugas</title>
<div class="container">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Buat Tugas Baru</h3>
        </div>
        <div class="card-body">
            <!-- Tampilkan pesan error jika ada -->
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('guru.tugas-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="judul">Judul Tugas</label>
                    <input type="text" name="judul" class="form-control" required>
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <select name="mapel_id" class="form-control" required>
                        <option value="">Pilih Mapel</option>
                        @foreach($mapels as $item)
                            <option value="{{ $item->mapel->id }}">{{ $item->mapel->nama_mapel }}</option>
                        @endforeach

                    </select>
                    @error('mapel_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="kelas_id">Kelas</label>
                    <select name="kelas_id" class="form-control" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($mapels as $item)
                            <option value="{{ $item->kelas->id }}">{{ $item->kelas->nama_kelas }}</option>
                        @endforeach

                    </select>
                    @error('kelas_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_pengumpulan">Tanggal Pengumpulan</label>
                    <input type="date" name="tanggal_pengumpulan" class="form-control" required min="{{ date('Y-m-d') }}">
                    @error('tanggal_pengumpulan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="file">Upload File</label>
                    <input type="file" name="file" class="form-control">
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Toggle Switch untuk Visibilitas Jawaban --}}
                <div class="form-group mb-3">
                    <label>Visibilitas Jawaban Siswa</label>
                    <div class="d-flex align-items-center" style="gap: 15px;">
                        <input type="hidden" name="answers_visible_to_others" value="0">
                        
                        <label class="toggle-switch">
                          <input type="checkbox" name="answers_visible_to_others" value="1">
                          <span class="slider"></span>
                        </label>
                        
                        <small class="text-muted">
                            Aktifkan jika siswa boleh melihat jawaban siswa lain.
                        </small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Buat Tugas</button>
                <a href="{{ route('guru.tugas-siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
