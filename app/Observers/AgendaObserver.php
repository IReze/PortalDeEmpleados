<?php

namespace App\Observers;

use App\Models\Directorio;
use App\Models\AuditoriaLog;
use Illuminate\Support\Facades\Auth;

class AgendaObserver
{
    /**
     * Se ejecuta después de crear un registro.
     */
    public function created(Directorio $directorio): void
    {
        $this->registrarLog('CREAR', $directorio);
    }

    /**
     * Se ejecuta después de actualizar un registro.
     */
    public function updated(Directorio $directorio): void
    {
        $this->registrarLog('EDITAR', $directorio);
    }

    /**
     * Se ejecuta después de eliminar un registro.
     */
    public function deleted(Directorio $directorio): void
    {
        $this->registrarLog('ELIMINAR', $directorio);
    }

    /**
     * Función privada para centralizar la creación del log.
     */
    private function registrarLog(string $accion, Directorio $directorio): void
    {
        AuditoriaLog::create([
            'user_id'     => Auth::id() ?? 1, // El ID del usuario logueado
            'accion'      => $accion,
            'modulo'      => 'AGENDA',
            'registro_id' => $directorio->id,
            'detalles'    => "Contacto: {$directorio->nombre} | Área: {$directorio->area}",
        ]);
    }
}