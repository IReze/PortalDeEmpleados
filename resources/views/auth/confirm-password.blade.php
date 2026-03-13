@extends('layouts.app')

@section('title', 'Confirmar Contraseña')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 33.476 33.476 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915V10a.5.5 0 0 1-1 0V7.915A1.5 1.5 0 0 1 8 5z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-2">Confirmar Acceso</h3>
        <p class="text-muted small mb-4 px-3">
            Por seguridad, confirme su contraseña antes de continuar con esta acción.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="text-start mb-4 px-3">
                <label for="password" class="form-label fw-bold small text-muted">Contraseña</label>
                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                    <input id="password" type="password" 
                           class="form-control border-0 bg-light @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" autofocus
                           placeholder="Ingrese su contraseña actual">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block mt-2" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="px-3">
                <button type="submit" class="btn-chiapas-primary shadow-sm border-0">
                    Confirmar Contraseña
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="mt-4 pt-3 border-top mx-3">
                    <p class="small text-muted">
                        <a href="{{ route('password.request') }}" style="color: var(--verde-chiapas); font-weight: 700; text-decoration: none;">
                            ¿Olvidó su contraseña?
                        </a>
                    </p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection