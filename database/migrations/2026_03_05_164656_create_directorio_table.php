<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up(): void
        {
        Schema::create('directorio', function (Blueprint $table) {
                $table->id();
                $table->string('area');        // Ej: UNIDAD DE INFORMÁTICA
                $table->string('nombre');      // Ej: Mtro. Gilberto Vázquez Rincón
                $table->string('cargo')->nullable();
                $table->string('extension')->nullable();
                $table->string('piso')->nullable();
                $table->timestamps(); // Esto permite saber cuándo se agregó o editó el registro
                $table->softDeletes(); // OPCIONAL: Permite "eliminar" sin borrar permanentemente de la base de datos
            });
        }
    public function down(): void
    {
        Schema::dropIfExists('directorio');
    }
};
