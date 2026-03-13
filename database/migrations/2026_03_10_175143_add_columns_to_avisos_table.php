<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            // Añadimos el tipo de comunicado
            $table->enum('tipo', ['Aviso', 'Circular'])->default('Aviso')->after('id');
            // Añadimos la ruta del archivo PDF
            $table->string('archivo')->nullable()->after('mensaje');
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'archivo']);
        });
    }
};