<?php 
namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon; 
class AsistenciaController extends Controller 
{ 
    public function index(Request $request) 
    { 
        \Carbon\Carbon::setLocale('es'); // Forzar idioma español
    // ... resto de tu código
        // ✓ CURP del usuario autenticado (ya no hardcoded) 
       $curp = auth()->user()->curp;
  
        // Fechas por defecto: hoy (día hábil) y 15 días hábiles atrás 
        $hoy = Carbon::today(); 
  
        if ($hoy->isWeekend()) { 
            $hoy = $hoy->previousWeekday(); 
        } 
  
        $desdeDefault = $hoy->copy(); 
        $diasContados = 0; 
        while ($diasContados < 14) { 
            $desdeDefault->subDay(); 
            if ($desdeDefault->isWeekday()) { 
                $diasContados++; 
            } 
        } 
  
// Cambia estas líneas en tu controlador
    $fecha_inicio = Carbon::parse($request->input('fecha_inicio', $desdeDefault))->format('Y-m-d 00:00:00');
    $fecha_fin    = Carbon::parse($request->input('fecha_fin', $hoy))->format('Y-m-d 23:59:59');
  
        // 1. Consulta principal (detalle de registros) 
        $query = DB::connection('sqlsrv_reloj') 
            ->table('dbo.cat_personal as P') 
            ->leftJoin('dbo.tbl_asistencia as A', 'P.id_personal', '=', 'A.id_personal') 
            ->leftJoin('dbo.cat_incidencia as I', 'A.id_incidencia', '=', 'I.id_incidencia') 
            ->leftJoin('dbo.cat_justificacion as J', 'A.id_justificacion', '=','J.id_justificacion') 
            ->select( 
                'P.id_personal', 'P.curp', 'P.paterno', 'P.materno', 'A.Df_Fecha', 
                DB::raw("FORMAT(A.Df_Fecha, 'dddd', 'es-ES') AS NombreDia"), 
                DB::raw("FORMAT(A.h_entrada, 'hh:mm tt', 'es-ES') AS h_entrada"), 
                DB::raw("FORMAT(A.h_salida, 'hh:mm tt', 'es-ES') AS h_salida"), 
                'A.observacion', 
                'I.descripcion as incidencia', 
                'J.descripcion AS Justificacion'
            )
            ->where('P.curp', $curp); 
  
        // 2. Consulta de resumen 
        $resumenQuery = DB::connection('sqlsrv_reloj') 
            ->table('dbo.cat_personal as P') 
            ->leftJoin('dbo.tbl_asistencia as A', 'P.id_personal', '=', 
                'A.id_personal') 
            ->leftJoin('dbo.cat_incidencia as I', 'A.id_incidencia', '=', 
                'I.id_incidencia') 
            ->select( 
                DB::raw("SUM(CASE WHEN I.id_incidencia = 1 THEN 1 ELSE 0 END) AS normales"), 
                DB::raw("SUM(CASE WHEN I.id_incidencia = 2 THEN 1 ELSE 0 END) AS retardos"), 
                DB::raw("SUM(CASE WHEN I.id_incidencia = 3 THEN 1 ELSE 0 END) AS faltas"), 
                DB::raw("SUM(CASE WHEN I.id_incidencia = 4 THEN 1 ELSE 0 END) AS justificadas") 
            ) 
            ->where('P.curp', $curp); 
  
        // 3. Aplicar filtro de fechas 
        $query->whereBetween('A.Df_Fecha', [$fecha_inicio, $fecha_fin]); 
        $resumenQuery->whereBetween('A.Df_Fecha', [$fecha_inicio, $fecha_fin]); 
  
        $asistencias = $query->orderBy('A.Df_Fecha', 'ASC')->get(); 
        $resumen     = $resumenQuery->first(); 
  
        // 4. Exportar PDF 
        if ($request->input('export') === 'pdf') { 
            $user          = auth()->user(); 
            $fechaDescarga = now()->format('d/m/Y h:i A'); 
  
            $pdf = Pdf::loadView('pdf.reporte-asistencia-pdf', compact( 
                'asistencias', 'resumen', 'fecha_inicio', 'fecha_fin', 'user', 'fechaDescarga' 
            )); 
            $pdf->setPaper('A4', 'landscape'); 
            return $pdf->download('Reporte_Asistencia.pdf'); 
        } 
  
        // 5. Vista web 
        return view('asistencias.index', compact( 
            'asistencias', 'resumen', 'fecha_inicio', 'fecha_fin' 
        )); 
    } 
} 
 