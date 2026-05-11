<?php

namespace App\Http\Controllers;

use App\Models\Directorio;
use Illuminate\Http\Request;
// Importaciones para seguridad Laravel 11/12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AgendaController extends Controller implements HasMiddleware
{
    /**
     * Definición de Middlewares para el controlador.
     */
    public static function middleware(): array
    {
        return [
            // El permiso 'gestionar agenda' se aplica a todo, excepto a la vista principal
            new Middleware('can:gestionar agenda', except: ['index']),
        ];
    }

    /**
     * Muestra el directorio con búsqueda dinámica y orden alfabético.
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $contactos = Directorio::where(function($query) use ($buscar) {
                if ($buscar) {
                    $query->where('nombre', 'LIKE', "%$buscar%")
                          ->orWhere('area', 'LIKE', "%$buscar%")
                          ->orWhere('extension', 'LIKE', "%$buscar%");
                }
            })
            ->orderBy('nombre', 'asc')
            ->paginate(15);

        // --- LÓGICA PARA BÚSQUEDA DINÁMICA (AJAX) ---
        if ($request->ajax()) {
            return response()->json([
                'html' => view('agenda.partials.tabla_filas', compact('contactos'))->render(),
                'pagination' => $contactos->appends(['buscar' => $buscar])->links('pagination::bootstrap-5')->render()
            ]);
        }

        return view('agenda.index', compact('contactos'));
    }

    /**
     * Creación del nuevo registro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'area'      => 'required|string|max:255',
            'cargo'     => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:20',
            'piso'      => 'nullable|string|max:10',
        ]);

        Directorio::create($request->all());

        return redirect()->route('agenda.index')
            ->with('status', 'El registro de ' . $request->nombre . ' ha sido creado con éxito.');
    }

    /**
     * Actualiza los datos de un servidor público.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'area'      => 'required|string|max:255',
            'cargo'     => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:20',
            'piso'      => 'nullable|string|max:10',
        ]);

        $persona = Directorio::findOrFail($id);
        $persona->update($request->all());

        return redirect()->route('agenda.index')
            ->with('status', 'El registro de ' . $persona->nombre . ' ha sido actualizado con éxito.');
    }

    /**
     * Elimina un registro del directorio.
     */
    public function destroy($id)
    {
        $persona = Directorio::findOrFail($id);
        $persona->delete(); 

        return redirect()->route('agenda.index')
            ->with('status', 'Registro eliminado correctamente.');
    }
}