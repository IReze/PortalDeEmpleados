@extends('layouts.app')

@section('content')
<div class="full-center-container">
    <div class="auth-card">
        <div class="user-avatar-circle-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-1-.966V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v5.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Z"/>
                <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.5.5 0 0 0 .774-.148l1.385-2.308a.5.5 0 0 0-.172-.686Z"/>
                <path d="M1 4.294 8 8.705l7-4.412V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v.294Z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-3">Verifique su Correo</h3>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="background-color: #e6f5f3; color: var(--verde-chiapas); border-radius: 8px;">
                <small><strong>¡Enviado!</strong> Se ha enviado un nuevo enlace de verificación a su correo electrónico.</small>
            </div>
        @endif

        <p class="text-muted mb-4 px-3">
            Antes de continuar, por favor verifique su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar. Si no recibió el mensaje, puede solicitar otro haciendo clic en el botón de abajo.
        </p>

        <div class="d-grid gap-2 px-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-chiapas-primary mb-3 shadow-sm border-0 w-100">
                    Reenviar Correo de Verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: var(--guinda-chiapas); font-weight: 600;">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>
@endsection