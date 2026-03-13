<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function index() {
        $avisos = \App\Models\Aviso::latest()->paginate(10); // Trae todos los avisos, el más reciente primero
        return view('avisos.index', compact('avisos'));
    }

    public function show($id) {
        $aviso = Aviso::findOrFail($id);
        return view('avisos.show', compact('aviso'));
    }
   public function store(Request $request) {
        $request->validate([
            'titulo'  => 'required|max:255',
            'mensaje' => 'required',
            'tipo'    => 'required|in:Aviso,Circular',
            'archivo' => 'nullable|mimes:pdf|max:10240', // Aumentamos a 10MB por si las circulares son pesadas
        ]);

        $datos = $request->all();

        if ($request->hasFile('archivo')) {
            // Guardamos el PDF en la carpeta 'public/avisos' dentro del storage
            $ruta = $request->file('archivo')->store('avisos', 'public');
            $datos['archivo'] = $ruta;
        }

    \App\Models\Aviso::create($datos);

    return redirect()->back()->with('status', '¡Comunicado y documento publicados con éxito!');
    }
    public function destroy($id) {
        $aviso = Aviso::findOrFail($id);
        $aviso->delete();

        return redirect()->back()->with('status', '¡Comunicado eliminado con éxito!');
    }
    public function update(Request $request, $id) {
        $request->validate([
            'titulo'  => 'required|max:255',
            'mensaje' => 'required',
            'tipo'    => 'required|in:Aviso,Circular',
        ]);

        $aviso = Aviso::findOrFail($id);
        $aviso->update($request->all());

        return redirect()->back()->with('status', '¡Comunicado actualizado con éxito!');
    }
}