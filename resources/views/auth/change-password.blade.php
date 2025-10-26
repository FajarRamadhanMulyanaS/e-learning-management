<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center position-relative">
                <a href="{{ url()->previous() }}" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y ms-3">
                    ← Kembali
                </a>
                <h3 class="m-0">Ganti Password</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('change-password.update') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="current_password">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
