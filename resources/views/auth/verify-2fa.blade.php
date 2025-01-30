@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1E1E1E, #4A4A4A);
        color: white;
        font-family: 'Arial', sans-serif;
    }
    .auth-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .auth-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 30px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }
    .auth-card h2 {
        margin-bottom: 20px;
    }
    .form-control {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        border: 1px solid #17A2B8;
        color: white;
        box-shadow: none;
    }
    .btn-custom {
        background: #17A2B8;
        color: white;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: #1DB9D3;
    }
    .btn-link {
        color: #FFD54F;
        text-decoration: none;
    }
    .btn-link:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <h2>🔐 Autenticación en Dos Pasos</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verify-2fa') }}">
            @csrf

            <div class="mb-3">
                <label for="token" class="form-label">Ingresa el código de 6 dígitos enviado a tu correo</label>
                <input id="token" type="text" class="form-control @error('token') is-invalid @enderror" name="token" required autofocus>

                @error('token')
                    <span class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-custom w-100">Verificar</button>
        </form>

        <form method="POST" action="{{ route('resend-2fa') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-link">Reenviar Código</button>
        </form>
    </div>
</div>
@endsection
