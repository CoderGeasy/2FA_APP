@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1E1E1E, #4A4A4A);
        color: white;
        font-family: 'Arial', sans-serif;
    }
    .login-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 30px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }
    .login-card h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-control {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        border: 1px solid #FFC107;
        color: white;
        box-shadow: none;
    }
    .btn-custom {
        background: #FFC107;
        color: #1E1E1E;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: #FFD54F;
        color: black;
    }
    .recaptcha-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <h2>🔒 Iniciar Sesión</h2>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                @error('email')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                @error('password')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="6LcyRcYqAAAAAHlCudDmTHUDEh0SKlBjFXC-hEDf"></div>
            </div>

            <button type="submit" class="btn btn-custom w-100">Acceder</button>
        </form>
    </div>
</div>
@endsection
