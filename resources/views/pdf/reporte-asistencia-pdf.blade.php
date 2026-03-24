<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 24px 32px; }

        /* ── HEADER ─────────────────────────────────────────── */
        .header {
            background: #009887;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .header-inner  { display: table; width: 100%; }
        .header-logo   { display: table-cell; width: 60px; vertical-align: middle; }
        .header-logo img { max-width: 52px; max-height: 44px; }
        .header-title  { display: table-cell; vertical-align: middle; padding-left: 10px; }
        .header-title h2 { font-size: 14px; font-weight: bold; margin-bottom: 2px; }

        /* ── META ───────────────────────────────────────────── */
        .meta { font-size: 10px; color: #666; margin-bottom: 10px; }
        .meta .empleado-nombre { font-size: 13px; font-weight: bold; color: #111; }
        .meta .descargado { padding-left: 16px; }

        /* ── RESUMEN — mismo tamaño compacto que .summary-card ── */
        .summary-row  { display: table; width: 100%; margin-bottom: 14px; border-spacing: 6px; }
        .summary-box  {
            display: table-cell;
            width: 25%;
            padding: 8px 10px;
            border-radius: 6px;
            text-align: left;
            vertical-align: middle;
        }
        .summary-box .label { font-size: 9px; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 2px; }
        .summary-box .value { font-size: 18px; font-weight: bold; display: block; }

        .box-normal      { background: #e8f5e9; border: 1px solid #c8e6c9; color: #2e7d32; }
        .box-retardo     { background: #fff3cd; border: 1px solid #ffeeba; color: #856404; }
        .box-falta       { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .box-justificada { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }

        /* ── TABLA ───────────────────────────────────────────── */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            font-size: 9px;
            text-transform: uppercase;
            padding: 7px 8px;
            text-align: left;
            color: #555;
            border-bottom: 2px solid #009887;
            letter-spacing: 0.3px;
        }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #eee; font-size: 10px; }

        .badge { padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        /* Colores institucionales para el PDF */
        .box-normal      { background:  #009887; color: white; border: none; }
        .box-retardo     { background: #D4A017; color: white; border: none; }
        .box-falta       { background: #C90166; color: white; border: none; }
        .box-justificada { background:  #1e6484; color: white; border: none; }

        /* ── FOOTER ──────────────────────────────────────────── */
        .footer { margin-top: 16px; font-size: 9px; color: #aaa; text-align: right; border-top: 1px solid #eee; padding-top: 6px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-inner">
            <div class="header-logo">
                <img src="{{ public_path('images/escudo-icono.png') }}" alt="Chiapas">
            </div>
            <div class="header-title">
                <h2>Historial de Asistencia</h2>
                <span style="font-size: 11px; font-weight: bold;">Periodo: {{ $fecha_inicio ?? 'N/A' }} — {{ $fecha_fin ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <div class="meta">
        <strong>Empleado:</strong>
        <span class="empleado-nombre">{{ $user->name ?? 'N/A' }}</span>
        <span class="descargado"><strong>Descargado:</strong> {{ $fechaDescarga }}</span>
    </div>

    {{-- Resumen --}}
    <div class="summary-row">
        <div class="summary-box box-normal">
            <span class="label">Normales</span>
            <span class="value">{{ $resumen->normales ?? 0 }}</span>
        </div>
        <div class="summary-box box-retardo">
            <span class="label">Retardos</span>
            <span class="value">{{ $resumen->retardos ?? 0 }}</span>
        </div>
        <div class="summary-box box-falta">
            <span class="label">Faltas</span>
            <span class="value">{{ $resumen->faltas ?? 0 }}</span>
        </div>
        <div class="summary-box box-justificada">
            <span class="label">Justificadas</span>
            <span class="value">{{ $resumen->justificadas ?? 0 }}</span>
        </div>
    </div>

    {{-- Tabla --}}
    <table>
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
            @forelse($asistencias as $a)
            <tr>
                <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($a->Df_Fecha)->format('d/m/Y') }}</td>
                <td style="text-transform: capitalize;">{{ $a->NombreDia }}</td>
                <td>{{ $a->h_entrada ?? '--:--' }}</td>
                <td>{{ $a->h_salida ?? '--:--' }}</td>
                <td>
                    @if($a->incidencia)
                        @php
                            $inc = strtolower($a->incidencia);
                            $cls = str_contains($inc, 'normal') ? 'badge-normal'
                                 : (str_contains($inc, 'retardo') ? 'badge-retardo'
                                 : (str_contains($inc, 'falta') ? 'badge-falta' : 'badge-justificada'));
                        @endphp
                        <span class="badge {{ $cls }}">{{ $a->incidencia }}</span>
                    @else -
                    @endif
                </td>
                <td>{{ $a->Justificacion ?? '-' }}</td>
                <td>{{ $a->observacion ?? 'Ninguna' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#999; padding:20px;">Sin registros en el periodo.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Generado el {{ $fechaDescarga }} · Portal de Empleados</div>

</body>
</html>