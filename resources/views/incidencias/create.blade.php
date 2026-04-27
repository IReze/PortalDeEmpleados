@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm" style="border-radius: 12px; border-left: 5px solid var(--guinda-chiapas);">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--guinda-chiapas);">Nueva Solicitud de Incidencia</h4>
            <p class="text-muted small mb-0">Complete los campos para generar su formato oficial</p>
        </div>
    </div>

    <form action="{{ route('incidencias.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- Columna Izquierda: Información del Empleado --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 text-muted small border-bottom pb-2 text-uppercase">Datos del Solicitante</h6>
                        <div class="mb-3">
                            <label class="small fw-bold text-secondary">NOMBRE:</label>
                            <p class="mb-0 fw-bold text-dark">{{ $empleado->nombre }} {{ $empleado->paterno }} {{ $empleado->materno }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-secondary">CATEGORÍA:</label>
                            <p class="mb-0 text-dark small">{{ $empleado->categoria }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-secondary">RELACIÓN LABORAL:</label>
                            <p class="mb-0 text-dark small">{{ $empleado->relacion_laboral }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-secondary">ADSCRIPCIÓN:</label>
                            <p class="mb-0 text-dark small">{{ $empleado->adscripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna Derecha: Formulario --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- SELECCIÓN DE JEFE --}}
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Dirigir Solicitud a (Vo.Bo.):</label>
                                <select name="id_personal_jefe" class="form-select border-0 bg-light p-3 shadow-none" required style="border-left: 5px solid var(--verde-chiapas) !important;">
                                    <option value="" selected disabled>-- Seleccione al Jefe de Área --</option>
                                    @foreach($jefes as $j)
                                        <option value="{{ $j->id_personal }}">{{ $j->nombre_completo }} | {{ $j->puesto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- TIPO DE INCIDENCIA --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo de Incidencia:</label>
                                <select name="tipo" class="form-select border-0 bg-light shadow-none" required>
                                    <option value="Incapacidad">1.- Incapacidad</option>
                                    <option value="Permiso Económico">2.- Permiso Económico</option>
                                    <option value="Omisión Registro de Entrada">3.- Omisión Registro de Entrada</option>
                                    <option value="Omisión Registro de Salida">4.- Omisión Registro de Salida</option>
                                    <option value="Ambas Omisiones">5.- Omisión Entrada y Salida</option>
                                </select>
                            </div>

                            {{-- CALENDARIO --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha o Periodo:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-range"></i></span>
                                    <input type="text" name="rango_fechas" id="calendario" class="form-control border-0 bg-light shadow-none" placeholder="Seleccione fecha(s)" required readonly>
                                </div>
                            </div>

                            {{-- MOTIVO --}}
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold">Motivo o Justificación:</label>
                                <textarea name="motivo" rows="4" class="form-control border-0 bg-light shadow-none" placeholder="Escriba la razón de su solicitud..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 text-end">
                        <button type="submit" class="btn btn-lg text-white fw-bold px-5 shadow" style="background-color: var(--verde-chiapas); border-radius: 10px;">
                            <i class="bi bi-file-pdf me-2"></i>Generar Solicitud
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- --- FIX VISUAL DEL CALENDARIO --- --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Forzar que el calendario sea un bloque sólido y no una lista */
    .flatpickr-calendar { 
        background: #fff !important; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        width: 315px !important;
    }
    .flatpickr-days { width: 315px !important; display: flex !important; flex-wrap: wrap !important; }
    .flatpickr-day { flex-basis: 14.28% !important; max-width: 14.28% !important; height: 38px !important; line-height: 38px !important; }
    
    /* Colores institucionales en el calendario */
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
        background: var(--verde-chiapas) !important;
        border-color: var(--verde-chiapas) !important;
    }
    .flatpickr-day.inRange {
        background: #e8f5e9 !important;
        box-shadow: -5px 0 0 #e8f5e9, 5px 0 0 #e8f5e9 !important;
    }
    /* Estilo para los días de la semana (L M M J V...) */
    span.flatpickr-weekday { background: #f8f9fa !important; color: #666 !important; font-weight: bold !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#calendario", {
            mode: "range",
            locale: "es",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: false,
            static: true // Esto pega el calendario al input para evitar que flote mal
        });
    });
</script>
@endsection