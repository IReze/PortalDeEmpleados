@extends('layouts.app')

@section('title', 'Registro de Empleado')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        
        <div class="register-photo-wrapper">
            <div class="register-avatar-circle">
                <i class="bi bi-person-fill"></i>
                
                <i class="bi bi-plus-circle-fill"></i>
            </div>
        </div>
        
        <h3 class="fw-bold mb-2">Registro de Empleado</h3>
        <p class="text-muted small mb-4 px-3">Complete los campos para crear su cuenta en el portal institucional.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="text-start mb-3 px-3">
                <label for="curp" class="form-label fw-bold small text-muted">CURP</label>
                <input id="curp" type="text" 
                       class="form-control @error('curp') is-invalid @enderror" 
                       name="curp" value="{{ old('curp') }}" 
                       required placeholder="Ingrese sus 18 caracteres" 
                       maxlength="18" style="border-radius: 8px; border: 1px solid #ddd;">
                @error('curp')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="text-start mb-3 px-3">
                <label for="email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" 
                       required placeholder="ejemplo@gmail.com"
                       style="border-radius: 8px; border: 1px solid #ddd;">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row px-3">
                <div class="col-md-6 text-start mb-3">
                    <label for="password" class="form-label fw-bold small text-muted">Contraseña</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" required
                           style="border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div class="col-md-6 text-start mb-3">
                    <label for="password-confirm" class="form-label fw-bold small text-muted">Confirmar</label>
                    <input id="password-confirm" type="password" 
                           class="form-control" name="password_confirmation" 
                           required style="border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div class="px-3">
                <button type="submit" class="btn-chiapas-primary mt-3 shadow-sm border-0">
                    Registrarse ahora
                </button>
            </div>

            <div class="mt-4 pt-3 border-top mx-3">
                <p class="small text-muted">
                    ¿Ya tiene una cuenta activa? <br>
                    <a href="{{ route('login') }}" style="color: var(--verde-chiapas); font-weight: 700; text-decoration: none;">Inicie sesión aquí</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection