<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
        }

        .card-header h3 {
            margin: 0;
        }

        .btn-primary, .btn-secondary {
            min-width: 140px;
        }

        .img-thumbnail {
            border: 2px solid #007bff;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center">
                    <h3>Edit Profil</h3>
                </div>
                <div class="card-body bg-light">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.update_profil', ['id' => $admin->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label text-primary">Username</label>
                            <input type="text" name="username" id="username" class="form-control" 
                                   value="{{ $admin->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-primary">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ $admin->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label text-primary">Foto Profil</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                            @if ($admin->foto)
                                <img src="{{ asset($admin->foto) }}" alt="Foto Admin" 
                                     class="img-thumbnail mt-2" style="width: 150px;">
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
