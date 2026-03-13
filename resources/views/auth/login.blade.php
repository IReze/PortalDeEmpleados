@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-2">Iniciar Sesión</h3>
        <p class="text-muted small mb-4">Ingrese sus credenciales para acceder al portal</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="text-start mb-3 px-2">
                <label for="email" class="form-label small fw-bold text-muted">Correo Electrónico</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" 
                       required autocomplete="email" autofocus 
                       style="border-radius: 8px;">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-start mb-3 px-2">
                <label for="password" class="form-label small fw-bold text-muted">Contraseña</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password"
                       style="border-radius: 8px;">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small text-muted" for="remember">
                        Recordarme
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: var(--verde-chiapas); font-size: 13px; text-decoration: none; font-weight: 600;">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </div>

            <div class="px-2">
                <button type="submit" class="btn-chiapas-primary border-0 shadow-sm">
                    Entrar al Portal
                </button>
            </div>

            @if (Route::has('register'))
                <div class="mt-4 pt-3 border-top mx-2">
                    <p class="small text-muted">
                        ¿Aún no tiene cuenta? <br>
                        <a href="{{ route('register') }}" style="color: var(--verde-chiapas); font-weight: 700; text-decoration: none;">Cree una aquí</a>
                    </p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection