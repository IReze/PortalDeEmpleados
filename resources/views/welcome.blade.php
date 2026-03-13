@extends('layouts.app')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        <div class="user-avatar-circle-lg">
            <i class="bi bi-person-fill"></i>
        </div>
        
        <h2 class="fw-bold text-dark mb-2">Bienvenido</h2>
        <p class="text-muted mb-4">Inicie sesión para acceder al portal de empleados</p>

        <a href="{{ route('login') }}" class="btn-chiapas-primary mb-3">
            Iniciar Sesión
        </a>

        <div class="mt-3">
            <small class="text-muted">¿Todavía no tienes cuenta? 
                <a href="{{ route('register') }}" style="color: var(--verde-chiapas); font-weight: 700; text-decoration: none;">
                    Regístrate aquí
                </a>
            </small>
        </div>
    </div>
</div>
@endsection