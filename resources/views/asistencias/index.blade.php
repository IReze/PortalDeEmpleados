 
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
            <div class="date-group"> 
                <div class="input-field"> 
                    <label>Desde</label> 
                    <input type="date" name="fecha_inicio" 
                           value="{{ $fecha_inicio }}" 
                           class="{{ !empty($fecha_inicio) ? 'has-value' : '' }}"> 
                </div> 
                <div class="input-field"> 
                    <label>Hasta</label> 
                    <input type="date" name="fecha_fin" 
                           value="{{ $fecha_fin }}" 
                           class="{{ !empty($fecha_fin) ? 'has-value' : '' }}"> 
                </div> 
                <div class="input-field"> 
                    <button type="submit" style="background-color:#009887;color:white; 
                        border:none;padding:9px 20px;border-radius:6px; 
                        font-weight:600;cursor:pointer;"> 
                        Filtrar 
                    </button> 
                </div> 
                <div class="input-field" style="margin-left:auto;"> 
                    <button type="submit" name="export" value="pdf" class="btn-export"> 
                        Exportar PDF 
                    </button> 
                </div> 
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
  
@endsection 