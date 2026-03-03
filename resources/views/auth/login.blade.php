@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<style>
    /* Contenedor principal */
    .login-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 20px;
        padding-bottom: 80px; /* Evita que pegue al footer */
    }

    .login-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        text-align: center;
    }

    /* Icono de usuario circular*/
    .user-avatar-circle {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #009887, #007d6f);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: white;
        box-shadow: 0 5px 15px rgba(0, 152, 135, 0.3);
    }

    /* Estilo de los inputs */
    .form-control {
        border-radius: 6px;
        padding: 12px 15px;
        border: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #009887;
        box-shadow: 0 0 0 0.2rem rgba(0, 152, 135, 0.25);
    }

    /* Botón Magenta*/
    .btn-login {
        background-color: #C90166;
        border: none;
        color: white;
        padding: 12px;
        width: 100%;
        border-radius: 6px;
        font-weight: 700;
        font-size: 16px;
        transition: background 0.3s ease;
        margin-top: 10px;
    }

    .btn-login:hover {
        background-color: #a30152;
        color: white;
    }

    .forgot-link {
        color: #009887;
        font-size: 13px;
        text-decoration: none;
        font-weight: 600;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="user-avatar-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            </svg>
        </div>

        <h3 class="mb-2 fw-bold">Iniciar Sesión</h3>
        <p class="text-muted small mb-4">Ingrese sus credenciales para acceder</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="text-start mb-3">
                <label for="email" class="form-label small fw-bold">Correo Electrónico</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-start mb-3">
                <label for="password" class="form-label small fw-bold">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="remember">
                        Recordarme
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        ¿Olvidó su contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-login">
                Entrar al Portal
            </button>
        </form>
    </div>
</div>
@endsection