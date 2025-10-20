@extends('layout_new.app')

@section('konten')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">Daftar Guru Mapel</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addGuruMapelModal">
        <i class="fas fa-plus-circle"></i> Tambah Guru Mapel
    </button>
<div class="row">
    <div class="col-md-12">
        <div class="card">
    <div class="table-responsive">
        <table id="basic-datatables" class="display table table-striped table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Pengajar</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guruMapels as $index => $guruMapel)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guruMapel->user ? $guruMapel->user->username : 'Tidak Ada Guru' }}</td>
                    <td>{{ $guruMapel->mapel ? $guruMapel->mapel->nama_mapel : 'Tidak Ada Mapel' }}</td>
                    <td>{{ $guruMapel->kelas ? $guruMapel->kelas->nama_kelas : 'Tidak Ada Kelas' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editGuruMapelModal{{ $guruMapel->id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $guruMapel->id }})">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $guruMapel->id }}" action="{{ route('admin.guru-mapel.destroy', $guruMapel->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit Guru Mapel -->
                <div class="modal fade" id="editGuruMapelModal{{ $guruMapel->id }}" tabindex="-1" role="dialog" aria-labelledby="editGuruMapelModalLabel{{ $guruMapel->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="editGuruMapelModalLabel{{ $guruMapel->id }}">Edit Guru Mapel</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.guru-mapel.update', $guruMapel->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="user_id">Pilih Guru</label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="">Pilih Guru</option>
                                            @foreach($guru as $g)
                                                <option value="{{ $g->id }}" {{ $g->id == $guruMapel->user_id ? 'selected' : '' }}>{{ $g->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="mapel_id">Pilih Mata Pelajaran</label>
                                        <select name="mapel_id" class="form-control" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @foreach($mapels as $mapel)
                                                <option value="{{ $mapel->id }}" {{ $mapel->id == $guruMapel->mapel_id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kelas_id">Pilih Kelas</label>
                                        <select name="kelas_id" class="form-control" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelas as $kelasItem)
                                                <option value="{{ $kelasItem->id }}" {{ $kelasItem->id == $guruMapel->kelas_id ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<!-- Modal Tambah Guru Mapel -->
<div class="modal fade" id="addGuruMapelModal" tabindex="-1" role="dialog" aria-labelledby="addGuruMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addGuruMapelModalLabel">Tambah Guru Mapel</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.guru-mapel.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="user_id">Pilih Guru</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Pilih Guru</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mapel_id">Pilih Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kelas_id">Pilih Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $kelasItem)
                                <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus dengan JavaScript -->
<script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>
@endsection
