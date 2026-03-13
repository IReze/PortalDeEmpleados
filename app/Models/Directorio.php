<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Esta línea es la que faltaba corregir

class Directorio extends Model
{
    use SoftDeletes; // Ahora Laravel sabrá de dónde viene este Trait

    protected $table = 'directorio';

    protected $fillable = [
        'area',
        'nombre',
        'cargo',
        'extension',
        'piso'
    ];
}