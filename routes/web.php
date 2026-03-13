<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AgendaController; // Importación necesaria
use App\Http\Controllers\AvisoController; // Importación necesaria
use App\Http\Controllers\AsistenciaController; // Importación necesaria

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // UNIFICAMOS AQUÍ LA RUTA DEL PERFIL
    Route::get('/profile/edit', function () {
        $user = Auth::user();
        
        try {
            // Buscamos al empleado usando la CURP real que ya guardamos en MySQL
            $empleado = DB::connection('sqlsrv_reloj')
                ->table('cat_personal')
                ->where('curp', $user->curp)
                ->first();
        } catch (\Exception $e) {
            $empleado = null;
        }

        return view('profile.edit', compact('user', 'empleado'));
    })->name('profile.edit');

    // Rutas adicionales
   Route::middleware(['auth', 'verified'])->group(function () {

   
        Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
        Route::get('/avisos', [AvisoController::class, 'index'])->name('avisos.index');
        Route::get('/avisos/{id}', [AvisoController::class, 'show'])->name('avisos.show');
        Route::post('/avisos', [AvisoController::class, 'store'])->name('avisos.store');
        Route::put('/avisos/{id}', [AvisoController::class, 'update'])->name('avisos.update');
        Route::delete('/avisos/{id}', [AvisoController::class, 'destroy'])->name('avisos.destroy');


        // Rutas para el directorio institucional
        Route::put('/agenda/{id}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    });
    
});