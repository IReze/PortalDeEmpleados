@extends('layouts.app')

@section('title', 'Control de Asistencias')

@section('content')
<div class="attendance-wrapper">
    <div class="attendance-card">
        {{-- Encabezado Institucional --}}
        <header class="attendance-header">
            <div>
                <h2 class="fw-bold mb-0" style="font-size: 1.2rem; color: var(--oscuro-chiapas);">Historial de Asistencia</h2>
                <small class="text-muted">Visualizando registros del periodo actual</small>
            </div>
        </header>

        {{-- RESUMEN: Usa tus clases globales .grid-summary y .summary-card --}}
        <div class="grid-summary">
            <div class="summary-cards-row">
                <div class="summary-card box-normal">
                    <h4 class="summary-title">Normales</h4>
                    <span class="summary-value">{{ $resumen->normales ?? 0 }}</span>
                </div>
                <div class="summary-card box-retardo">
                    <h4 class="summary-title">Retardos</h4>
                    <span class="summary-value">{{ $resumen->retardos ?? 0 }}</span>
                </div>
                <div class="summary-card box-falta">
                    <h4 class="summary-title">Faltas</h4>
                    <span class="summary-value">{{ $resumen->faltas ?? 0 }}</span>
                </div>
                <div class="summary-card box-justificada">
                    <h4 class="summary-title">Justificadas</h4>
                    <span class="summary-value">{{ $resumen->justificadas ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- FILTROS: Adaptados para celular --}}
        <form method="GET" action="{{ route('asistencias.index') }}" class="mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-end align-items-md-end gap-3 px-1">
                <div class="input-field-chiapas w-100">
                    <label>Desde</label>
                    <div class="input-with-icon">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" name="fecha_desde" class="form-control datepicker" 
                               placeholder="aaaa-mm-dd" value="{{ request('fecha_desde') }}">
                    </div>
                </div>

                <div class="input-field-chiapas w-100">
                    <label>Hasta</label>
                    <div class="input-with-icon">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" name="fecha_hasta" class="form-control datepicker" 
                               placeholder="aaaa-mm-dd" value="{{ request('fecha_hasta') }}">
                    </div>
                </div>

                <div class="d-flex gap-2 w-100">
                    <button type="submit" class="btn-filtrar-chiapas w-100">
                        <i class="bi bi-search me-2"></i> Filtrar
                    </button>
                    <a href="{{ route('asistencias.pdf', array_merge(request()->all(), ['export' => 'pdf'])) }}" 
                       class="btn-export-pdf-chiapas w-100">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                    </a>
                </div>
            </div>
        </form>

        {{-- TABLA: Diseño Limpio con Scroll Lateral --}}
        <div class="grid-table">
            <div class="table-responsive">
                <table class="table-custom mb-0 w-100" style="min-width: 850px;">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Fecha</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Incidencia</th>
                            <th>Justificación</th>
                            <th class="pe-4">Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($asistencias as $asistencia)
                    <tr class="align-middle">
                        {{-- FECHA CON JERARQUÍA VISUAL --}}
                        <td class="text-nowrap ps-4 py-3">
                            <div class="d-flex align-items-baseline">
                                <span class="fw-bold fs-5 me-1" style="color: var(--oscuro-chiapas);">
                                    {{ \Carbon\Carbon::parse($asistencia->Df_Fecha)->format('d') }}
                                </span>
                                <span class="text-capitalize small fw-semibold" style="color: var(--oscuro-chiapas);">
                                    {{ \Carbon\Carbon::parse($asistencia->Df_Fecha)->translatedFormat('M, Y') }}
                                </span>
                            </div>
                            <div class="text-muted text-capitalize small" style="margin-top: -2px;">
                                {{ $asistencia->NombreDia }}
                            </div>
                        </td>

                        <td class="text-nowrap fw-medium">{{ $asistencia->h_entrada ?? '--:--' }}</td>
                        <td class="text-nowrap fw-medium">{{ $asistencia->h_salida ?? '--:--' }}</td>
                        
                        <td>
                            @if($asistencia->incidencia)
                                @php
                                    $clase = 'bg-secondary';
                                    if(str_contains(strtolower($asistencia->incidencia), 'normal')) $clase = 'bg-normal';
                                    if(str_contains(strtolower($asistencia->incidencia), 'retardo')) $clase = 'bg-retardo-badge';
                                    if(str_contains(strtolower($asistencia->incidencia), 'falta')) $clase = 'bg-falta-badge';
                                    if(str_contains(strtolower($asistencia->incidencia), 'justificado')) $clase = 'bg-justificada-badge';
                                @endphp
                                <span class="badge-status {{ $clase }}">{{ $asistencia->incidencia }}</span>
                            @else <span class="text-muted">-</span> @endif
                        </td>

                        <td>
                            @if($asistencia->Justificacion)
                                <span class="badge-status bg-justificada-badge">{{ $asistencia->Justificacion }}</span>
                            @else <span class="text-muted">-</span> @endif
                        </td>

                        <td class="small text-muted pe-4">
                            {{ $asistencia->observacion ?? 'Ninguna' }}
                        </td>
                    </tr>
                    @endforeach

                    @if($asistencias->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No se encontraron registros en el periodo seleccionado.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración de Flatpickr usando tus estilos globales (.form-control.input)
        const fpConfig = {
            locale: "es",
            dateFormat: "Y-m-d",
            altInput: true,
            altInputClass: "form-control input",
            altFormat: "d M, Y",
        };

        const desde = flatpickr("input[name='fecha_desde']", {
            ...fpConfig,
            onChange: (selectedDates, dateStr) => hasta.set('minDate', dateStr)
        });

        const hasta = flatpickr("input[name='fecha_hasta']", fpConfig);
    });
</script>
@endsection