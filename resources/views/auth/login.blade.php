@extends('layouts.app')

@section('content')
<body>
<link rel="shortcut icon" href="{{ asset('images') }}/logoku.webp"/>
<div id="background-container" style="min-height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;">
    <div class="card shadow-lg border-0 rounded-3" style="background: rgba(0, 0, 0, 0.7); color: white; width: 100%; max-width: 400px;">
        <div class="card-header text-center py-4">
            <h3 class="mb-0">{{ __('Login') }}</h3>
        </div>

        <div class="card-body p-4">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input dinamis untuk email/NIS/NIP -->
                <div class="mb-4">
                    <label id="dynamic-label" for="identifier" class="form-label">{{ __('Masukan ID pelajar') }}</label>
                    <input id="identifier" type="text" class="form-control bg-dark text-white border-0 @error('identifier') is-invalid @enderror" name="identifier" value="{{ old('identifier') }}" required autofocus placeholder="Enter your email/nis/nip">

                    @error('identifier')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <!-- Input password -->
                <div class="mb-4 position-relative">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control bg-dark text-white border-0 @error('password') is-invalid @enderror"
                        name="password" required placeholder="Enter your password">
                    <span class="toggle-password" style="position: absolute; top: 55%; right: 10px;  cursor: pointer;">
                        <i id="password-icon" class="fas fa-eye" style="color: #5e4c4c;"></i>
                    </span>

                    @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" style="background: #6a1b9a; border-color: #6a1b9a;">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>

<style>
    #background-container {
        background-image: url('{{ asset('landing/img/bglanding.jpg') }}');
    }

    /* Ubah background untuk perangkat mobile */
    @media (max-width: 768px) {
        #background-container {
            background-image: url('{{ asset('images/login-mobile.jpg') }}');
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        document.querySelector('.toggle-password').addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    });
</script>

</body>
@endsection
