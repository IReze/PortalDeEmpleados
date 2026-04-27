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
      Schema::create('jefes_areas', function (Blueprint $table) {
            $table->id();
            // ID del área física en SQL Server (debe ser único para que un área no tenga 2 jefes)
            $table->integer('id_areafisica'); 
            // ID del empleado que es jefe en SQL Server
            $table->integer('id_personal_jefe'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jefes_areas');
    }
};
