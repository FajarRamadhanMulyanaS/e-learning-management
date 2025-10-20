@extends('layout_new.app')

@section('konten')

<style>
    .container-fluid {
        background-color: white;
    }

    h1 {
        font-family: Times, sans-serif;
        margin-left: 60px;
        margin-top: 10px;
    }

    .content {
        margin-left: 10px;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        margin: 20px 60px;
    }

    .button-group .btn {
        margin-left: 10px;
    }

    .btn-action {
        margin-right: 5px;
    }

    .table-responsive {
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    thead th {
        text-transform: uppercase;
        font-size: 14px;
    }

    tfoot th {
        background-color: #f4f4f4;
    }

    .btn-action {
        margin-right: 5px;
    }

    .dataTables_filter {
        float: right;
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
    }
    .card-header{
        background-color: white;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-chalkboard-teacher"></i> Daftar Guru</h1>
            </div>
        </div>
    </div>
</div>
<br>

<!-- Menampilkan Pesan Sukses -->
@if (session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

<!-- Menampilkan Error Validasi -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Basic</h4>
                <div class="btn-group" role="group">
                    <!-- Tombol untuk membuka modal upload Excel -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadExcelModal">
                        <i class="fas fa-upload"></i> Upload Excel
                    </button>

                    <!-- Tombol untuk download template Excel -->
                    <button class="btn btn-success">
                        <a href="{{ route('admin.guru.downloadTemplateGuru') }}" style="color: white; text-decoration: none;">
                            <i class="fas fa-file-download"></i> Download Template
                        </a>
                    </button>

                    <!-- Tombol untuk membuka modal tambah guru -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahGuruModal">
                        <i class="fas fa-user-plus"></i> Tambah Guru
                    </button>
                </div>
            </div>

            <!-- Modal Upload Excel -->
            <div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadExcelModalLabel">Upload File Excel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk Upload File Excel -->
                            <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Guru -->
            <div class="modal fade" id="tambahGuruModal" tabindex="-1" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahGuruModalLabel">Tambah Guru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Tambah Guru -->
                            <form action="{{ route('admin.guru.storeGuru') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nip">NIP:</label>
                                    <input type="text" class="form-control" name="nip" id="nip" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Nama:</label>
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Telepon:</label>
                                    <input type="text" class="form-control" name="telepon" id="telepon" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" required>
                                </div>
                                <div class="form-group">
                                    <label for="jabatan">Jabatan:</label>
                                    <input type="text" class="form-control" name="jabatan" id="jabatan" required>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir:</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Jabatan</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Jabatan</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($user->foto)
                                        <img src="{{ asset('images/profil_guru/' . $user->foto) }}" alt="Foto Guru" width="50" height="50">
                                    @else
                                        <img src="{{ asset('images/default.png') }}" alt="Default Foto" width="50" height="50">
                                    @endif
                                </td>
                                <td>{{ $user->guru->nip }}</td> <!-- Akses NIP dari relasi guru -->
                                <td>{{ $user->username }}</td> <!-- Akses username dari tabel users -->
                                <td>{{ $user->guru->telepon }}</td> <!-- Akses telepon dari relasi guru -->
                                <td>{{ $user->guru->gender }}</td> <!-- Akses gender dari relasi guru -->
                                <td>{{ $user->guru->alamat }}</td> <!-- Akses alamat dari relasi guru -->
                                <td>{{ $user->guru->jabatan }}</td> <!-- Akses jabatan dari relasi guru -->
                                <td>{{ $user->guru->tgl_lahir }}</td> <!-- Akses tanggal lahir dari relasi guru -->

                                <td>
                                    <!-- Menempatkan semua tombol dalam satu kolom -->
                                    <div class="d-flex justify-content-center">
                                        <!-- Tombol Edit membuka modal edit -->
                                        <button class="btn btn-warning btn-action" data-toggle="modal" data-target="#editGuruModal-{{ $user->id }}"> <i class="fas fa-edit"></i> Edit </button>
                                         <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.guru.deleteGuru', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>

                                <!-- Modal Edit Guru -->
                                <div class="modal fade" id="editGuruModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editGuruModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editGuruModalLabel">Edit Guru</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form Edit Guru -->
                                                <form action="{{ route('admin.guru.updateGuru', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="form-group">
                                                        <label for="nip">NIP:</label>
                                                        <input type="text" class="form-control" name="nip" id="nip" value="{{ $user->guru->nip }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="username">Nama:</label>
                                                        <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telepon">Telepon:</label>
                                                        <input type="text" class="form-control" name="telepon" id="telepon" value="{{ $user->guru->telepon }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="gender">Gender:</label>
                                                        <select name="gender" id="gender" class="form-control" required>
                                                            <option value="Laki-laki" {{ $user->guru->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="Perempuan" {{ $user->guru->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat">Alamat:</label>
                                                        <input type="text" class="form-control" name="alamat" id="alamat" value="{{ $user->guru->alamat }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jabatan">Jabatan:</label>
                                                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{ $user->guru->jabatan }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tgl_lahir">Tanggal Lahir:</label>
                                                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $user->guru->tgl_lahir }}" required>
                                                    </div>
                                                    <!-- Tambahkan input untuk upload foto -->
                                                    <div class="form-group">
                                                        <label for="foto">Foto Profil:</label>
                                                        <input type="file" class="form-control-file" name="foto" accept="image/*">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Simpan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script> $(document).ready(function() {
    $('#basic-datatables').DataTable({ "language": {
         "lengthMenu": "Tampilkan _MENU_ entri",
          "zeroRecords": "Tidak ada data yang ditemukan",
           "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada entri tersedia",
             "infoFiltered": "(filter dari _MAX_ total entri)",
              "search": "Cari:",
               "paginate": { "first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya" }
            }
        });
    });
</script>
