<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    Route::get('/agenda', function () { return view('agenda.index'); })->name('agenda.index');
    Route::get('/asistencias', function () { return view('asistencias.index'); })->name('asistencias.index');
});