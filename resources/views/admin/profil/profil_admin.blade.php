<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>

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

        img {
            border-radius: 12px;
            border: 3px solid #007bff;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center">
                    <h3 class="mb-0">Profil Admin</h3>
                </div>
                <div class="card-body bg-light">
                    <div class="text-center mb-4">
                        <img src="{{ asset($admin->foto) }}" alt="Foto Admin"
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
                                    <a href="{{ route('auth.change-password2') }}" class="text-decoration-none ms-2">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
