@extends('layout2.app')

@section('konten')
<title>Edit Profil</title>
<div class="container my-2">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Edit Profil Siswa</h3>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-body p-3">
            <form id="editProfileForm" action="{{ route('siswa.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="username" class="form-label">Nama</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ $siswa->nis }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ $siswa->nisn }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                    <small class="form-text text-muted">Pastikan email yang Anda masukkan sudah benar.</small>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $siswa->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $siswa->telepon }}" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" class="form-control-file" id="foto" name="foto">
                    @if($user->foto)
                        <img src="{{ asset('images/profil_siswa/' . $user->foto) }}" alt="Foto Profil" class="mt-2" width="100">
                    @endif
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="confirmEmail()">Simpan Perubahan</button>
                    <a href="{{ route('siswa.profil_siswa') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmEmail() {
    const emailInput = document.getElementById('email').value;

    if (emailInput) {
        Swal.fire({
            title: 'Konfirmasi Email',
            text: 'Pastikan email yang Anda masukkan sudah benar: ' + emailInput,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editProfileForm').submit(); // Submit form jika konfirmasi
            }
        });
    }
}

</script>
@endsection
