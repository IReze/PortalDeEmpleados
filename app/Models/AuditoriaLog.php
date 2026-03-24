<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaLog extends Model
{
    protected $fillable = ['user_id', 'accion', 'modulo', 'registro_id', 'detalles'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
