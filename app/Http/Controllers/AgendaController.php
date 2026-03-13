<?php

namespace App\Http\Controllers;

use App\Models\Directorio; // Asegúrate de que el modelo esté creado
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Muestra el directorio con búsqueda y orden alfabético.
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        // Consulta con filtros y orden de la A a la Z
        $contactos = Directorio::where(function($query) use ($buscar) {
                if ($buscar) {
                    $query->where('nombre', 'LIKE', "%$buscar%")
                          ->orWhere('area', 'LIKE', "%$buscar%")
                          //->orWhere('cargo', 'LIKE', "%$buscar%")
                          ->orWhere('extension', 'LIKE', "%$buscar%");
                }
            })
            ->orderBy('nombre', 'asc') // Orden alfabético obligatorio
            ->paginate(15);

        // Retorna la vista en la carpeta agenda
        return view('agenda.index', compact('contactos'));
    }

    /**
     * Actualiza los datos de un servidor público desde el Modal.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos institucionales
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'area'      => 'required|string|max:255',
            'cargo'     => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:20',
            'piso'      => 'nullable|string|max:10',
        ]);

        $persona = Directorio::findOrFail($id);
        
        // Actualización masiva de los campos
        $persona->update([
            'nombre'    => $request->nombre,
            'area'      => $request->area,
            'cargo'     => $request->cargo,
            'extension' => $request->extension,
            'piso'      => $request->piso,
        ]);

        return redirect()->route('agenda.index')
            ->with('status', 'El registro de ' . $persona->nombre . ' ha sido actualizado con éxito.');
    }
    public function store(Request $request)
    {
        // Validación de datos institucionales
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'area'      => 'required|string|max:255',
            'cargo'     => 'nullable|string|max:255',
            'extension' => 'nullable|string|max:20',
            'piso'      => 'nullable|string|max:10',
        ]);

        // Creación del nuevo registro
       Directorio::create($request->all());

        return redirect()->route('agenda.index')
            ->with('status', 'El registro de ' . $request->nombre . ' ha sido creado con éxito.');
    }

    /**
     * Elimina (Soft Delete) un registro del directorio.
     */
    public function destroy($id)
    {
        $persona = Directorio::findOrFail($id);
        $persona->delete(); // Usa SoftDeletes si está configurado en el modelo

        return redirect()->route('agenda.index')
            ->with('status', 'Registro eliminado correctamente.');
    }
}