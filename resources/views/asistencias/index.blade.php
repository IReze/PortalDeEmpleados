 
@extends('layouts.app') 
  
@section('title', 'Control de Asistencia') 
  
@section('content') 
  
  
<div class="attendance-wrapper"> 
    <div class="attendance-card"> 
        <header class="attendance-header"> 
            <div> 
                <h2 style="margin:0; font-size: 1rem;">Historial de Asistencia</h2> 
                <small>Visualizando registros del periodo actual</small> 
            </div> 
        </header> 
  
       {{-- RESUMEN --}}
        <div class="grid-summary">
            <div class="summary-cards-row">
                <div class="summary-card box-normal">
                    <div>
                        <h4 class="summary-title">Normales</h4>
                        <span class="summary-value">{{ $resumen->normales ?? 0 }}</span>
                    </div>
                </div>

                <div class="summary-card box-retardo">
                    <div>
                        <h4 class="summary-title">Retardos</h4>
                        <span class="summary-value">{{ $resumen->retardos ?? 0 }}</span>
                    </div>
                </div>

                <div class="summary-card box-falta">
                    <div>
                        <h4 class="summary-title">Faltas</h4>
                        <span class="summary-value">{{ $resumen->faltas ?? 0 }}</span>
                    </div>
                </div>

                <div class="summary-card box-justificada">
                    <div>
                        <h4 class="summary-title">Justificadas</h4>
                        <span class="summary-value">{{ $resumen->justificadas ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
  
        {{-- FILTROS --}} 
        <form method="GET" action="{{ route('asistencias.index') }}" class="filters section"> 
          <div class="d-flex justify-content-end align-items-end gap-3 mb-5 mt-3 px-1">
    
                <div class="input-field-chiapas">
                    <label>Desde</label>
                    <div class="input-with-icon">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" name="fecha_desde" class="form-control datepicker" 
                            placeholder="aaaa-mm-dd" value="{{ request('fecha_desde') }}">
                    </div>
                </div>

                <div class="input-field-chiapas">
                    <label>Hasta</label>
                    <div class="input-with-icon">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" name="fecha_hasta" class="form-control datepicker" 
                            placeholder="aaaa-mm-dd" value="{{ request('fecha_hasta') }}">
                    </div>
                </div>

                <button type="submit" class="btn-filtrar-chiapas">
                    <i class="bi bi-search me-2"></i> Filtrar
                </button>

                <a href="{{ route('asistencias.pdf', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn-export-pdf-chiapas">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Exportar PDF
                </a>
            </div>
        </form> 
  
        {{-- TABLA --}} 
        <div class="layout-grid"> 
            <div class="grid-table"> 
                <table class="table-custom"> 
                    <thead> 
                        <tr> 
                            <th>Fecha</th> 
                            <th>Día</th> 
                            <th>Entrada</th> 
                            <th>Salida</th> 
                            <th>Incidencia</th> 
                            <th>Justificación</th> 
                            <th>Observación</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                    @foreach($asistencias as $asistencia) 
                    <tr> 
                        <td class="text-nowrap"> 
                            {{ \Carbon\Carbon::parse($asistencia->Df_Fecha)->translatedFormat('d \d\e F \d\e Y') }} 
                        </td> 
                        <td style="text-transform:capitalize;">{{ $asistencia->NombreDia }}</td> 
                        <td class="text-nowrap">{{ $asistencia->h_entrada ?? '--:--' }}</td> 
                        <td class="text-nowrap">{{ $asistencia->h_salida ?? '--:--' }}</td> 
                        
                        {{-- Columna Incidencia con colores dinámicos --}}
                        <td> 
                            @if($asistencia->incidencia) 
                                @php
                                    $claseIncidencia = 'bg-secondary'; // Gris por defecto
                                    if(str_contains(strtolower($asistencia->incidencia), 'normal')) $claseIncidencia = 'bg-normal';
                                    if(str_contains(strtolower($asistencia->incidencia), 'retardo')) $claseIncidencia = 'bg-retardo-badge';
                                    if(str_contains(strtolower($asistencia->incidencia), 'falta')) $claseIncidencia = 'bg-falta-badge';
                                    if(str_contains(strtolower($asistencia->incidencia), 'justificado')) $claseIncidencia = 'bg-justificada-badge';
                                @endphp
                                <span class="badge-status {{ $claseIncidencia }}"> 
                                    {{ $asistencia->incidencia }} 
                                </span> 
                            @else - 
                            @endif 
                        </td> 

                        {{-- Columna Justificación con color guinda o verde según tu diseño --}}
                        <td> 
                            @if($asistencia->Justificacion) 
                                <span class="badge-status bg-justificacion-badge"> 
                                    {{ $asistencia->Justificacion }} 
                                </span> 
                            @else - 
                            @endif 
                        </td> 
                        <td>{{ $asistencia->observacion ?? 'Ninguna' }}</td> 
                    </tr> 
                    @endforeach
  
                        @if($asistencias->isEmpty()) 
                        <tr> 
                            <td colspan="8" style="text align:center;color:#999;padding:30px;"> 
                                Seleccione un rango de fechas o no hay registros. 
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
document.querySelectorAll('input[type="date"]').forEach(function(input) { 
    input.addEventListener('change', function() { 
        if (this.value) { this.classList.add('has-value'); } 
        else { this.classList.remove('has-value'); } 
    }); 
}); 
</script> 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración para el campo DESDE
        const desdePicker = flatpickr("input[name='fecha_desde']", {
            locale: "es",
            dateFormat: "Y-m-d",
            altInput: true,
            altInputClass: "form-control input",
            altFormat: "d F, Y",
            onChange: function(selectedDates, dateStr) {
                // Cuando cambia 'Desde', establecemos la fecha mínima de 'Hasta'
                hastaPicker.set('minDate', dateStr);
            }
        });

        // Configuración para el campo HASTA
        const hastaPicker = flatpickr("input[name='fecha_hasta']", {
            locale: "es",
            dateFormat: "Y-m-d",
            altInput: true,
            altInputClass: "form-control input",
            altFormat: "d F, Y",
        });
    });
</script>
  
@endsection 