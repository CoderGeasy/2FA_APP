@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-center bg-primary text-white fw-bold">
                {{ __('Bienvenido, ') . Auth::user()->name }} 🎉
            </div>

            <div class="card-body text-center">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h4 class="text-muted">Estás autenticado con éxito 🚀</h4>
                <p class="mt-3">Explora todas las funciones disponibles en tu cuenta.</p>

                <a href="{{ route('logout') }}" class="btn btn-danger mt-3"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
