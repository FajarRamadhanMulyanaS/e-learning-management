@extends('layout_new.app')

@section('konten')
<div class="container">
    <h2>Edit Kelas</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#editKelasModal">
        Edit Kelas
    </button>

    <!-- Modal -->
    <div class="modal fade" id="editKelasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/admin/kelas/update/' . $kelas->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_kelas" class="form-label">Kode Kelas</label>
                            <input type="text" name="kode_kelas" class="form-control" value="{{ $kelas->kode_kelas }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
