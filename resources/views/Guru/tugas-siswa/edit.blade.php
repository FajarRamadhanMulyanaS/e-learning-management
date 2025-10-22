@extends('layout2.app')

@section('konten')
<title>Edit soal</title>
<div class="container">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white text-center">
            <h3>Edit Tugas</h3>
        </div>
        <div class="card-body">
            <!-- Tampilkan pesan error jika ada -->
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form untuk mengedit tugas -->
            <form action="{{ route('guru.tugas-siswa.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="judul">Judul Tugas</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $tugas->judul) }}" required>
                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="mapel_id">Mata Pelajaran</label>
                    <select name="mapel_id" class="form-control" required>
                        <option value="">Pilih Mapel</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->mapel->id }}" {{ $mapel->mapel->id == $tugas->mapel_id ? 'selected' : '' }}>
                                {{ $mapel->mapel->nama_mapel }}
                            </option>
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
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->kelas->id }}" {{ $mapel->kelas->id == $tugas->kelas_id ? 'selected' : '' }}>
                                {{ $mapel->kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="tanggal_pengumpulan">Tanggal Pengumpulan</label>
                    <input type="date" name="tanggal_pengumpulan" class="form-control"
                           value="{{ old('tanggal_pengumpulan', optional($tugas->tanggal_pengumpulan)->format('Y-m-d')) }}"
                           required min="{{ date('Y-m-d') }}">
                    @error('tanggal_pengumpulan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="file">Upload File Baru (Opsional)</label>
                    <input type="file" name="file" class="form-control">
                    @if($tugas->file)
                        <p>File saat ini: <a href="{{ asset('storage/' . $tugas->file) }}" target="_blank">Lihat File</a></p>
                    @endif
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
                          <input type="checkbox" name="answers_visible_to_others" value="1" {{ old('answers_visible_to_others', $tugas->answers_visible_to_others) ? 'checked' : '' }}>
                          <span class="slider"></span>
                        </label>

                        <small class="text-muted">
                            Aktifkan jika siswa boleh melihat jawaban siswa lain.
                        </small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui Tugas</button>
                <a href="{{ route('guru.tugas-siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
