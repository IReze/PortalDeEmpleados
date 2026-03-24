<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        
        // Lista de usuarios para la pestaña de Roles
        $usuarios = User::where(function($q) use ($buscar) {
            if ($buscar) {
                $q->where('name', 'LIKE', "%$buscar%")
                ->orWhere('curp', 'LIKE', "%$buscar%");
            }
        })->paginate(10, ['*'], 'usuarios_page');

        // Lista de logs para la pestaña de Auditoría
        $logs = \App\Models\AuditoriaLog::with('user')
            ->latest()
            ->paginate(15, ['*'], 'logs_page');

        $roles = \Spatie\Permission\Models\Role::all();
        
        return view('usuarios.roles', compact('usuarios', 'roles', 'logs'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Evitar que el admin se quite el rango a sí mismo
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('status', 'Error: No puedes modificar tu propio nivel de acceso.');
        }

        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        // Sincroniza el rol (reemplaza los anteriores)
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('status', "Nivel de acceso de {$user->name} actualizado a " . strtoupper($request->role));
    }
}