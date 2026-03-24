<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\AsistenciaController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas por Autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- PERFIL ---
    Route::get('/profile/edit', function () {
        $user = Auth::user();
        try {
            $empleado = DB::connection('sqlsrv_reloj')
                ->table('cat_personal')
                ->where('curp', $user->curp)
                ->first();
        } catch (\Exception $e) {
            $empleado = null;
        }
        return view('profile.edit', compact('user', 'empleado'));
    })->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | RUTAS DE MÓDULOS
    |--------------------------------------------------------------------------
    | La seguridad detallada (quién edita y quién solo ve) ya la manejan 
    | los controladores internos mediante HasMiddleware.
    */

    // Asistencias (Requiere 'ver todo' para ver su propio historial)
    Route::middleware(['can:ver todo'])->group(function () {
        Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
        Route::get('/asistencias/pdf', [AsistenciaController::class, 'index'])->name('asistencias.pdf');
    });

    // Avisos y Agenda
    // Usamos 'resource' para simplificar, pero excluimos lo que no necesites.
    // La seguridad de Spatie protegerá los métodos Store, Update y Destroy automáticamente.
    Route::resource('avisos', AvisoController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('agenda', AgendaController::class)->only(['index', 'store', 'update', 'destroy']);

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/usuarios/roles', [App\Http\Controllers\UserController::class, 'index'])->name('usuarios.roles');
    Route::put('/usuarios/{user}/role', [App\Http\Controllers\UserController::class, 'updateRole'])->name('usuarios.updateRole');
});