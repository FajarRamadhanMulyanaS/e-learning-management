@extends('layout_new.app')

@section('konten')

<style>
    /* ... (style Anda tidak berubah) ... */
    .container-fluid {
        background-color: white;
    }

    h1 {
        font-family: Times, sans-serif;
        margin-left: 3px;
        margin-top: 3px;
    }

    .content {
        margin-left: 5px;
    }

    .button-group {
        display: flex;
        justify-content: flex-end; /* Menempatkan tombol di sebelah kanan */
        margin: 20px 60px; /* Memberikan margin atas dan bawah */
    }

    .button-group .btn {
        margin-left: 10px; /* Jarak antar tombol */
    }

    .btn-action {
        margin-right: 5px; /* Memberikan jarak antara tombol dalam tabel */
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
        margin-right: 5px; /* Spasi antar tombol dalam kolom aksi */
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
                <h1><i class="fas fa-users"></i> Daftar Siswa</h1>
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
                        <a href="{{ route('admin.siswa.downloadTemplateSiswa') }}" style="color: white; text-decoration: none;">
                            <i class="fas fa-file-download"></i> Download Template
                        </a>
                    </button>

                    <!-- Tombol untuk membuka modal tambah siswa -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahSiswaModal">
                        <i class="fas fa-user-plus"></i> Tambah Siswa
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
                            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
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

            <!-- Modal Tambah Siswa -->
            <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Tambah Siswa -->
                            <form action="{{ route('admin.siswa.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nis">NIS:</label>
                                    <input type="text" class="form-control" name="nis" id="nis" required>
                                </div>
                                <div class="form-group">
                                    <label for="nisn">NISN:</label>
                                    <input type="text" class="form-control" name="nisn" id="nisn" required>
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
                                    <label for="kelas_id">Kelas:</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control" required>
                                        <option value="">Pilih Kelas</option>
                                        {{-- Variabel $kelas ini dikirim dari SiswaController@index --}}
                                        @foreach ($kelas as $k) 
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
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
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Kelas</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Kelas</th>
                                <th>Gender</th>
                                <th>Alamat</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            {{-- Variabel $users ini dikirim dari SiswaController@index --}}
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($user->foto)
                                        <img src="{{ asset('images/profil_siswa/' . $user->foto) }}" alt="Foto Siswa" width="50" height="50">
                                    @else
                                        <img src="{{ asset('images/default.png') }}" alt="Default Foto" width="50" height="50">
                                    @endif
                                </td>
                                <td>{{ $user->siswa->nis ?? 'N/A' }}</td> <!-- Akses NIS dari relasi siswa -->
                                <td>{{ $user->siswa->nisn ?? 'N/A' }}</td> <!-- Akses NISN dari relasi siswa -->
                                <td>{{ $user->username }}</td> <!-- Akses username dari tabel users -->
                                <td>{{ $user->siswa->telepon ?? 'N/A' }}</td> <!-- Akses telepon dari relasi siswa -->
                                
                                {{-- 
                                  !! INI PERBAIKAN UTAMA (TABEL) !!
                                  Menggunakan relasi baru: $user->siswa->kelas->nama_kelas
                                  $user->kelas sudah tidak ada.
                                --}}
                                <td>
                                    @if ($user->siswa && $user->siswa->kelas)
                                        {{ $user->siswa->kelas->nama_kelas }}
                                    @else
                                        'Tidak ada kelas'
                                    @endif
                                </td>
                                
                                <td>{{ $user->siswa->gender ?? 'N/A' }}</td> <!-- Akses gender dari relasi siswa -->
                                <td>{{ $user->siswa->alamat ?? 'N/A' }}</td> <!-- Akses alamat dari relasi siswa -->
                                <td>{{ $user->siswa->tgl_lahir ?? 'N/A' }}</td> <!-- Akses tanggal lahir dari relasi siswa -->

                                    <td>
                                        <!-- Menempatkan semua tombol dalam satu kolom -->
                                        <div class="d-flex justify-content-center">
                                            <!-- Tombol Edit membuka modal edit -->
                                            <button class="btn btn-warning btn-action" data-toggle="modal" data-target="#editSiswaModal-{{ $user->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Modal Edit Siswa -->
                                            <div class="modal fade" id="editSiswaModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editSiswaModalLabel">Edit Siswa</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.siswa.updateSiswa', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('POST') <!-- Spoofing Method POST untuk Update -->

                                                                <div class="form-group">
                                                                    <label for="nis">NIS:</label>
                                                                    <input type="text" class="form-control" name="nis" value="{{ $user->siswa->nis ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nisn">NISN:</label>
                                                                    <input type="text" class="form-control" name="nisn" value="{{ $user->siswa->nisn ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="username">Nama:</label>
                                                                    <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                                                                </div>
                                                                
                                                                {{-- 
                                                                  !! INI PERBAIKAN UTAMA (MODAL EDIT) !!
                                                                  Mengganti input teks 'kelas' menjadi dropdown 'kelas_id'
                                                                  agar konsisten dengan modal 'Tambah Siswa'.
                                                                --}}
                                                                <div class="form-group">
                                                                    <label for="kelas_id">Kelas:</label>
                                                                    {{-- Pastikan $kelas dikirim dari Controller --}}
                                                                    <select name="kelas_id" id="kelas_id_{{ $user->id }}" class="form-control" required>
                                                                        <option value="">Pilih Kelas</option>
                                                                        @if(isset($kelas)) {{-- Tambahkan check ini --}}
                                                                            @foreach ($kelas as $k)
                                                                                <option value="{{ $k->id }}" {{ ($user->siswa && $user->siswa->kelas_id == $k->id) ? 'selected' : '' }}>
                                                                                    {{ $k->nama_kelas }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="telepon">Telepon:</label>
                                                                    <input type="text" class="form-control" name="telepon" value="{{ $user->siswa->telepon ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="gender">Gender:</label>
                                                                    <select name="gender" class="form-control" required>
                                                                        <option value="Laki-laki" {{ ($user->siswa && $user->siswa->gender == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                                                        <option value="Perempuan" {{ ($user->siswa && $user->siswa->gender == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat:</label>
                                                                    <input type="text" class="form-control" name="alamat" value="{{ $user->siswa->alamat ?? '' }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tgl_lahir">Tanggal Lahir:</label>
                                                                    <input type="date" class="form-control" name="tgl_lahir" value="{{ $user->siswa->tgl_lahir ?? '' }}" required>
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

                                            <!-- Form untuk delete -->
                                            <form action="{{ route('admin.siswa.deleteSiswa', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
</div>

@endsection

