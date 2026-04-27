<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            
            // Relación con el usuario que hace la solicitud (ID de tu tabla users en MySQL)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Datos que el usuario llena en el formulario
            $table->string('tipo');           // Ejemplo: 'Incapacidad', 'Permiso Económico', etc.
            $table->date('fecha_inicio');     // Fecha de inicio o fecha única
            $table->date('fecha_fin')->nullable(); // Solo para periodos (Incapacidad/Económico)
            $table->text('motivo');           // Justificación del trabajador

            // ID del Jefe seleccionado (Para saber a quién dirigir el Vo.Bo. en el PDF)
            // Guardamos el id_personal que viene de SQL Server
            $table->integer('id_personal_jefe');

            // Control de estado
            $table->string('estatus')->default('Pendiente'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};