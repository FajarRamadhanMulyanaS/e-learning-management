@extends('layout2.app')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Buat Kuis Baru</h4>
        </div>
        <div class="card-body">
            {{-- PENTING: Tambahkan enctype untuk upload file --}}
            <form action="{{ route('guru.quiz.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul" class="font-weight-bold">Judul Kuis</label>
                    <input type="text" class="form-control" id="judul" name="judul" required placeholder="">
                </div>

                <div class="form-group">
                    <label for="guru_mapel_id" class="font-weight-bold">Untuk Mata Pelajaran & Kelas</label>
                    <select class="form-control" id="guru_mapel_id" name="guru_mapel_id" required>
                        <option value="" disabled selected>-- Pilih Mata Pelajaran dan Kelas --</option>
                        @foreach($guruMapels as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->mapel->nama_mapel }} - Kelas {{ $item->kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Field Deskripsi Baru --}}
                <div class="form-group">
                    <label for="description" class="font-weight-bold">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder=""></textarea>
                </div>

                <hr>
                {{-- KODE YANG ANDA MINTA SUDAH DITAMBAHKAN DI SINI --}}
                <h5 class="mb-3">Lampiran</h5>
                <small class="form-text text-muted mb-3">Wajib diisi salah satu (file, link, atau gambar).</small>

                {{-- Field Attachment Baru --}}
                <div class="form-group">
                    <label for="attachment_file">Lampirkan File (PDF, Word, dll.)</label>
                    <input type="file" class="form-control-file" id="attachment_file" name="attachment_file">
                </div>

                <div class="form-group">
                    <label for="attachment_link">Sematkan Link (URL)</label>
                    <input type="url" class="form-control" id="attachment_link" name="attachment_link" placeholder="https://contoh-link.com/materi">
                </div>

                <div class="form-group">
                    <label for="attachment_image">Sematkan Gambar</label>
                    <input type="file" class="form-control-file" id="attachment_image" name="attachment_image" accept="image/*">
                </div>
                
                <hr>
                
                <button type="submit" class="btn btn-primary">Simpan dan Lanjut</button>
                <a href="{{ route('guru.quiz.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection