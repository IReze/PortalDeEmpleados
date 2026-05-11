@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="container-fluid p-3 p-md-5">
    {{-- Encabezado de Sección --}}
    <div class="mb-4">
        <h5 class="mb-0 fw-bold" style="color: var(--guinda-chiapas);">Panel de Control</h5>
        <hr style="border-top: 2px solid var(--guinda-chiapas); opacity: 1; width: 100%;">
    </div>

    <div class="row g-4">
        {{-- Card de Bienvenida Responsiva --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4 p-md-5" style="border-radius: 20px; background: white;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 text-center text-md-start">
                        <h2 class="fw-bold mb-2" style="color: var(--verde-chiapas); font-size: calc(1.5rem + 1vw);">¡Bienvenido al Portal!</h2>
                        <p class="text-muted fs-5 mb-0">Gestione su registro de asistencia, agenda y avisos institucionales de manera eficiente.</p>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-center">
                        {{-- Icono representativo o podrías poner una imagen institucional --}}
                        <i class="bi bi-shield-check" style="font-size: 5rem; color: rgba(0, 152, 135, 0.1);"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección de Avisos o Circulares --}}
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Avisos o Circulares</h5>
                        <i class="bi bi-megaphone-fill text-muted"></i>
                    </div>
                    <hr>

                    @php $ultimo = \App\Models\Aviso::latest()->first(); @endphp

                    @if($ultimo)
                        <div class="alert border-0 shadow-sm p-3" style="background-color: rgba(0, 152, 135, 0.05); border-left: 5px solid var(--verde-chiapas) !important; border-radius: 8px;">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                <div>
                                    <span class="badge mb-1" style="background-color: var(--verde-chiapas);">Nuevo {{ $ultimo->tipo }}</span>
                                    <h6 class="fw-bold mb-1 text-dark">{{ $ultimo->titulo }}</h6>
                                    <small class="text-muted d-block"><i class="bi bi-clock me-1"></i> Publicado {{ $ultimo->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('avisos.index') }}" class="btn btn-sm fw-bold text-white px-3 py-2" style="background-color: var(--guinda-chiapas); border-radius: 6px;">
                                        Ver aviso
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-chat-dots fs-1 text-light"></i>
                            <p class="text-muted mt-2 mb-0">No hay avisos o circulares actualmente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Acceso Rápido (Opcional, pero llena bien el espacio en PC) --}}
        <div class="col-12 col-md-4 col-lg-6">
            <div class="row g-3">
                <div class="col-6">
                    <a href="{{ route('asistencias.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-radius: 15px; transition: 0.3s;">
                            <i class="bi bi-clock-history fs-2 mb-2" style="color: var(--verde-chiapas);"></i>
                            <span class="small fw-bold text-dark">Mis Asistencias</span>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('agenda.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-radius: 15px; transition: 0.3s;">
                            <i class="bi bi-person-lines-fill fs-2 mb-2" style="color: var(--guinda-chiapas);"></i>
                            <span class="small fw-bold text-dark">Directorio</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Efecto hover para las tarjetas de acceso rápido */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection