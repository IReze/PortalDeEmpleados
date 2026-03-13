<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // Importamos el trait para eliminación lógica

class Aviso extends Model
{
   use HasFactory, SoftDeletes; // Habilitamos la eliminación lógica

    protected $table = 'avisos';

    protected $fillable = [
        'titulo',
        'mensaje',
        'tipo',
        'archivo',
    ];

    // Esto asegura que las fechas se traten como objetos Carbon
    protected $dates = ['deleted_at'];
}
