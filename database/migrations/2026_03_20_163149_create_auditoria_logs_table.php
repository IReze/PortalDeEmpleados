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
        Schema::create('auditoria_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); // Quién lo hizo
                $table->string('accion');               // Crear, Editar, Eliminar
                $table->string('modulo');               // Avisos, Agenda
                $table->string('registro_id');          // ID del elemento afectado
                $table->text('detalles')->nullable();    // Qué cambió (opcional)
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_logs');
    }
};
