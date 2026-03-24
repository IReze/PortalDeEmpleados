<?php

namespace App\Observers;

use App\Models\Aviso;
use App\Models\AuditoriaLog;
use Illuminate\Support\Facades\Auth;

class AvisoObserver
{
    public function created(Aviso $aviso)
    {
        $this->log('CREAR', $aviso);
    }

    public function updated(Aviso $aviso)
    {
        $this->log('EDITAR', $aviso);
    }

    public function deleted(Aviso $aviso)
    {
        $this->log('ELIMINAR', $aviso);
    }

    private function log($accion, $aviso)
    {
        AuditoriaLog::create([
            'user_id'     => Auth::id() ?? 1, // 1 por si es por consola
            'accion'      => $accion,
            'modulo'      => 'AVISOS',
            'registro_id' => $aviso->id,
            'detalles'    => "Título: {$aviso->titulo}",
        ]);
    }
}