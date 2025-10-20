@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Kuis: {{ $quiz->judul }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.quiz.update', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Method spoofing untuk update --}}

                <div class="form-group">
                    <label for="judul" class="font-weight-bold">Judul Kuis</label>
                    <input type="text" class="form-control" id="judul" name="judul" required value="{{ $quiz->judul }}">
                </div>

                <div class="form-group">
                    <label for="guru_mapel_id" class="font-weight-bold">Untuk Mata Pelajaran & Kelas</label>
                    <select class="form-control" id="guru_mapel_id" name="guru_mapel_id" required>
                        @foreach($guruMapels as $item)
                            <option value="{{ $item->id }}" {{ $quiz->guru_mapel_id == $item->id ? 'selected' : '' }}>
                                {{ $item->mapel->nama_mapel }} - Kelas {{ $item->kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description" class="font-weight-bold">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $quiz->description }}</textarea>
                </div>

                <hr>
                <h5 class="mb-3">Lampiran</h5>
                
                <div class="form-group">
                    <label>Ganti File (PDF, Word, dll.)</label>
                    @if($quiz->attachment_file)
                        <p class="small">File saat ini: <a href="{{ asset('storage/' . $quiz->attachment_file) }}" target="_blank">Lihat File</a></p>
                    @endif
                    <input type="file" class="form-control-file" name="attachment_file">
                </div>

                <div class="form-group">
                    <label for="attachment_link">Sematkan Link (URL)</label>
                    <input type="url" class="form-control" id="attachment_link" name="attachment_link" value="{{ $quiz->attachment_link }}">
                </div>

                <div class="form-group">
                    <label>Ganti Gambar</label>
                     @if($quiz->attachment_image)
                        <div class="mb-2">
                           <img src="{{ asset('storage/' . $quiz->attachment_image) }}" alt="Gambar Lampiran" class="img-thumbnail" width="200">
                        </div>
                    @endif
                    <input type="file" class="form-control-file" name="attachment_image" accept="image/*">
                </div>
                
                <hr>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('guru.quiz.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection