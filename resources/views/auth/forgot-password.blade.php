@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.5.5H7.465A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-2">Recuperar Acceso</h3>
        <p class="text-muted small mb-4 px-3">
            Ingrese su correos para recibir un enlace de restablecimiento de contraseña.
        </p>

        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="background-color: #e6f5f3; color: var(--verde-chiapas); border-radius: 8px;">
                <small>{{ session('status') }}</small>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="text-start mb-4 px-3">
                <label for="email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input id="email" type="email" 
                           class="form-control border-0 bg-light @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" 
                           required autocomplete="email" autofocus
                           placeholder="usuario@chiapas.gob.mx">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="px-3">
                <button type="submit" class="btn-chiapas-primary shadow-sm border-0">
                    Enviar enlace al correo
                </button>
            </div>

            <div class="mt-4 pt-3 border-top mx-3">
                <p class="small text-muted">
                    <a href="{{ route('login') }}" style="color: var(--verde-chiapas); font-weight: 700; text-decoration: none;">
                        <i class="bi bi-arrow-left me-1"></i> Regresar al inicio de sesión
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection