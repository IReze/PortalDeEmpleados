@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0" style="border-radius: 15px; max-width: 500px; width: 100%;">
        <div class="card-header text-white text-center p-4" style="background: linear-gradient(135deg, #611232 0%, #A85A78 100%); border-radius: 15px 15px 0 0;">
            <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-1-.966V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v5.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Z"/>
                    <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.5.5 0 0 0 .774-.148l1.385-2.308a.5.5 0 0 0-.172-.686Z"/>
                    <path d="M1 4.294 8 8.705l7-4.412V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v.294Z"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-0">Verifique su Correo</h4>
        </div>

        <div class="card-body p-5">
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="background-color: #e6f4ea; color: #1e7e34; border-left: 5px solid #28a745;">
                    <small><strong>¡Enviado!</strong> Se ha enviado un nuevo enlace de verificación a la dirección de correo proporcionada.</small>
                </div>
            @endif

            <p class="text-muted text-center mb-4">
                Antes de continuar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibió el correo, con gusto le enviaremos otro.
            </p>

            <div class="d-grid gap-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn w-100 text-white fw-bold shadow-sm" style="background-color: #611232; border-radius: 8px; padding: 12px; transition: 0.3s;">
                        Reenviar Correo de Verificación
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center mt-3">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none" style="color: #A85A78; font-size: 0.9rem;">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card-footer bg-light text-center py-3" style="border-radius: 0 0 15px 15px;">
            <small class="text-secondary fw-bold">Gobierno de Chiapas</small>
        </div>
    </div>
</div>

<style>
    btn-hover:hover {
        background-color: #A85A78 !important;
        color: white !important;
    }
</style>
@endsection