<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Importaciones necesarias para la seguridad en Laravel 11/12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AvisoController extends Controller implements HasMiddleware
{
    /**
     * Definición de Middlewares para el controlador.
     * Esto reemplaza el antiguo $this->middleware() del constructor.
     */
    public static function middleware(): array
    {
        return [
            // El permiso 'lanzar avisos' se aplica a todo, excepto a ver el listado y el detalle
            new Middleware('can:lanzar avisos', except: ['index', 'show']),
        ];
    }

    /**
     * Listado de avisos (Público para todos los empleados)
     */
    public function index() 
    {
        $avisos = Aviso::latest()->paginate(10);
        return view('avisos.index', compact('avisos'));
    }

    /**
     * Ver un aviso específico (Público)
     */
    public function show($id) 
    {
        $aviso = Aviso::findOrFail($id);
        return view('avisos.show', compact('aviso'));
    }

    /**
     * Guardar nuevo aviso (Solo RH y Admin)
     */
    public function store(Request $request) 
    {
        $request->validate([
            'titulo'  => 'required|max:255',
            'mensaje' => 'required',
            'tipo'    => 'required|in:Aviso,Circular',
            'archivo' => 'nullable|mimes:pdf|max:10240', // Máximo 10MB
        ]);

        $datos = $request->all();

        if ($request->hasFile('archivo')) {
            // Se guarda en storage/app/public/avisos
            $ruta = $request->file('archivo')->store('avisos', 'public');
            $datos['archivo'] = $ruta;
        }

        Aviso::create($datos);

        return redirect()->back()->with('status', '¡Comunicado y documento publicados con éxito!');
    }

    /**
     * Actualizar aviso (Solo RH y Admin)
     */
    public function update(Request $request, $id) 
    {
        $request->validate([
            'titulo'  => 'required|max:255',
            'mensaje' => 'required',
            'tipo'    => 'required|in:Aviso,Circular',
            'archivo' => 'nullable|mimes:pdf|max:10240',
        ]);

        $aviso = Aviso::findOrFail($id);
        $datos = $request->all();

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe para ahorrar espacio
            if ($aviso->archivo) {
                Storage::disk('public')->delete($aviso->archivo);
            }
            $datos['archivo'] = $request->file('archivo')->store('avisos', 'public');
        }

        $aviso->update($datos);

        return redirect()->back()->with('status', '¡Comunicado actualizado con éxito!');
    }

    /**
     * Eliminar aviso (Solo RH y Admin)
     */
    public function destroy($id) 
    {
        $aviso = Aviso::findOrFail($id);

        // Eliminar el PDF físico antes de borrar el registro de la base de datos
        if ($aviso->archivo) {
            Storage::disk('public')->delete($aviso->archivo);
        }

        $aviso->delete();

        return redirect()->back()->with('status', '¡Comunicado eliminado con éxito!');
    }
}