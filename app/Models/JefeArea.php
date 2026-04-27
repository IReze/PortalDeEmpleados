<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JefeArea extends Model
{
    protected $table = 'jefes_areas';
    protected $fillable = ['id_areafisica', 'id_personal_jefe'];
}
