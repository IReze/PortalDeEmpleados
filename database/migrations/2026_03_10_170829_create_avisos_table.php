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
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Aviso', 'Circular'])->default('Aviso'); // Columna 'tipo'
            $table->string('titulo');                                    // Columna 'titulo'
            $table->text('mensaje');                                     // Columna 'mensaje'
            $table->string('archivo')->nullable();                       // Columna 'archivo'
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
