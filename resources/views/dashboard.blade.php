@extends('layouts.app')

@section('content')
<div class="container-fluid p-5">
    <div class="mb-4">
        <h5 class="mb-0 fw-bold" style="color: var(--guinda-chiapas);">Panel de Control</h5>
        <hr style="border-top: 2px solid var(--guinda-chiapas); opacity: 1; width: 100%;">
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5" style="border-radius: 20px;">
                <h2 class="fw-bold" style="color: var(--verde-chiapas); font-size: 2.5rem;">Bienvenido al Portal</h2>
                <p class="text-muted fs-5">Gestione su registro de asistencia, Agenda y Avisos institucionales.</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm mt-4" style="border-radius: 15px;">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold text-start" style="color: var(--guinda-chiapas);">Avisos o Circulares</h5>
                    <hr>
                    @php $ultimo = \App\Models\Aviso::latest()->first(); @endphp

                    @if($ultimo)
                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center justify-content-between" style="background-color: rgba(40, 92, 77, 0.1); border-left: 5px solid var(--verde-chiapas) !important;">
                            <div>
                                <i class="bi bi-info-circle-fill me-2" style="color: var(--verde-chiapas);"></i>
                                <strong style="color: var(--verde-chiapas);">¡Nuevo {{ $ultimo->tipo }}!</strong>: {{ $ultimo->titulo }}
                            </div>
                            <a href="{{ route('avisos.index') }}" class="btn btn-sm text-white" style="background-color: var(--guinda-chiapas);">Ver aviso</a>
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay avisos o circulares actualmente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection