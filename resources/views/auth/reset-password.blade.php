@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.5.5H7.465A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-2">Nueva Contraseña</h3>
        <p class="text-muted small mb-4 px-3">
            Cree una nueva clave de acceso para su cuenta .
        </p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="text-start mb-3 px-3">
                <label for="email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                <input id="email" type="email" 
                       class="form-control bg-light border-0 @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email', $request->email) }}" 
                       required autocomplete="email" readonly
                       style="border-radius: 8px;">
                @error('email')
                    <span class="invalid-feedback d-block mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-start mb-3 px-3">
                <label for="password" class="form-label fw-bold small text-muted">Nueva Contraseña</label>
                <input id="password" type="password" 
                       class="form-control bg-light border-0 @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres"
                       style="border-radius: 8px;">
                @error('password')
                    <span class="invalid-feedback d-block mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="text-start mb-4 px-3">
                <label for="password-confirm" class="form-label fw-bold small text-muted">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" 
                       class="form-control bg-light border-0" 
                       name="password_confirmation" required autocomplete="new-password"
                       style="border-radius: 8px;">
            </div>

            <div class="px-3">
                <button type="submit" class="btn-chiapas-primary shadow-sm border-0">
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>
@endsection