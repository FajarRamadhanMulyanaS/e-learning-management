@extends('layout_new.app')

@section('konten')
<title>Ganti Password</title>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h3>Ganti Password</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
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

                <button type="submit" class="btn btn-primary">Ganti Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
