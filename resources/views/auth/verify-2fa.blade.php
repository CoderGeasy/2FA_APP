@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Two-Factor Authentication') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verify-2fa') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="token" class="form-label">{{ __('Enter the 6-digit token sent to your email') }}</label>
                            <input id="token" type="text" class="form-control @error('token') is-invalid @enderror" name="token" required autofocus>

                            @error('token')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
                    </form>

                    <form method="POST" action="{{ route('resend-2fa') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-link">{{ __('Resend Token') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
