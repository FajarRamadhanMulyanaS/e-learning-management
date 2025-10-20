@extends('layout_new.app')

@section('konten')
<div class="container py-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white text-center rounded-top">
                    <h3 class="mb-0">Profil Admin</h3>
                </div>
                <div class="card-body bg-light">
                    <div class="text-center mb-4">
                        <img src="{{ asset($admin->foto) }}" alt="Foto Admin"
                             class="rounded-circle border border-3 border-primary shadow-sm"
                             style="width: 150px; height: 200px; object-fit: cover;">
                    </div>
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" class="text-primary">Username</th>
                                <td>{{ $admin->username }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-primary">Email</th>
                                <td>{{ $admin->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-primary">Password</th>
                                <td>
                                    ******
                                    <a href="/change-password" class="btn btn-sm btn-warning ms-3">
                                        <i class="fas fa-lock"></i> Ubah Password
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.edit_profil', $admin->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
