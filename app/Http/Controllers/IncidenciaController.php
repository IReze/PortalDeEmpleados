<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Incidencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class IncidenciaController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $empleado = DB::connection('sqlsrv_reloj')->select("
            SELECT p.id_areafisica, p.nombre, p.paterno, p.materno, 
                   t.descripcion AS puesto, b.descripcion AS categoria, 
                   c.descripcion AS relacion_laboral, d.descripcion AS adscripcion
            FROM cat_personal p
            JOIN cat_puesto t ON p.id_puesto = t.id_puesto
            JOIN cat_categoria b ON p.id_categoria = b.id_categoria
            JOIN cat_tipo_plaza c ON p.id_tipo_plaza = c.id_tipo_plaza
            JOIN cat_area d ON p.id_areafisica = d.id_area
            WHERE p.curp = ? AND p.activo = 1
        ", [$user->curp])[0] ?? null;

        if (!$empleado) {
            return redirect()->back()->with('error', 'No se encontraron datos laborales.');
        }

        $idsJefes = DB::table('jefes_areas')
            ->where('id_areafisica', $empleado->id_areafisica)
            ->pluck('id_personal_jefe');

        $jefes = [];
        if ($idsJefes->isNotEmpty()) {
            $jefes = DB::connection('sqlsrv_reloj')->table('cat_personal as p')
                ->join('cat_puesto as t', 'p.id_puesto', '=', 't.id_puesto')
                ->select(
                    'p.id_personal',
                    DB::raw("(p.nombre + ' ' + p.paterno + ' ' + p.materno) as nombre_completo"),
                    't.descripcion as puesto'
                )
                ->whereIn('p.id_personal', $idsJefes)
                ->get();
        }

        return view('incidencias.create', compact('empleado', 'jefes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'rango_fechas' => 'required',
            'motivo' => 'required',
            'id_personal_jefe' => 'required'
        ]);

        // 1. Procesar Fechas
        $fechas = explode(" a ", $request->rango_fechas);
        $fecha_inicio = Carbon::parse($fechas[0]);
        $fecha_fin = isset($fechas[1]) ? Carbon::parse($fechas[1]) : $fecha_inicio;

        // Formatear periodo para el PDF (Ej: 07 y 08 de ENERO DE 2026)
        if ($fecha_inicio->eq($fecha_fin)) {
            $periodo_texto = $fecha_inicio->translatedFormat('d \d\e F \d\e Y');
        } else {
            $periodo_texto = $fecha_inicio->format('d') . " y " . $fecha_fin->translatedFormat('d \d\e F \d\e Y');
        }

        // 2. Guardar en MySQL
        $incidencia = Incidencia::create([
            'user_id' => auth()->id(),
            'tipo' => $request->tipo,
            'fecha_inicio' => $fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $fecha_fin->format('Y-m-d'),
            'motivo' => $request->motivo,
            'id_personal_jefe' => $request->id_personal_jefe,
        ]);

        // 3. Obtener datos para el PDF
        $user = auth()->user();
        $datos = DB::connection('sqlsrv_reloj')->select("
            SELECT p.nombre, p.paterno, p.materno, 
                   t.descripcion AS puesto, b.descripcion AS categoria, 
                   c.descripcion AS relacion_laboral, d.descripcion AS adscripcion
            FROM cat_personal p
            JOIN cat_puesto t ON p.id_puesto = t.id_puesto
            JOIN cat_categoria b ON p.id_categoria = b.id_categoria
            JOIN cat_tipo_plaza c ON p.id_tipo_plaza = c.id_tipo_plaza
            JOIN cat_area d ON p.id_areafisica = d.id_area
            WHERE p.curp = ?
        ", [$user->curp])[0];

        $jefe = DB::connection('sqlsrv_reloj')->select("
            SELECT (nombre + ' ' + paterno + ' ' + materno) as nombre_completo, 
                   t.descripcion as puesto
            FROM cat_personal p
            JOIN cat_puesto t ON p.id_puesto = t.id_puesto
            WHERE p.id_personal = ?
        ", [$request->id_personal_jefe])[0];

        // 4. Generar PDF
        $pdf = Pdf::loadView('incidencias.pdf', compact('incidencia', 'datos', 'jefe', 'periodo_texto'))
                  ->setPaper('letter', 'portrait');

        return $pdf->download('Solicitud_Incidencia_'.$user->curp.'.pdf');
    }
} // llave final de la clases