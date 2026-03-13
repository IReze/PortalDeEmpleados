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
        Schema::table('avisos', function (Blueprint $table) {
            // Esto añade la columna 'deleted_at' automáticamente
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
