@extends('layout_new.app')

@section('konten')
<div class="container">
    <h2>Edit Kelas</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#editKelasModal">
        Edit Kelas
    </button>

    <!-- Modal -->
    <div class="modal fade" id="editKelasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_kelas">Kode Kelas</label>
                            <input type="text" name="kode_kelas" class="form-control" value="{{ $kelas->kode_kelas }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
