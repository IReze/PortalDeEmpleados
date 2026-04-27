<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // 1. Normalizar CURP antes de validar (Mayúsculas y sin espacios)
        $input['curp'] = strtoupper(str_replace(' ', '', $input['curp'] ?? ''));

        // 2. Validación de formato y unicidad
        Validator::make($input, [
            'curp' => ['required', 'string', 'size:18', 'unique:users,curp'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(), // Esto usa PasswordValidationRules.php
        ], [
            // MENSAJES EN ESPAÑOL
            'curp.required' => 'La CURP es obligatoria.',
            'curp.size' => 'La CURP debe tener exactamente 18 caracteres.',
            'curp.unique' => 'Esta CURP ya está registrada en el sistema.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            // 'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            // 'password.max' => 'La contraseña no puede pasar de 15 caracteres.',
            // 'password.mixed_case' => 'Falta al menos una letra mayúscula.',
            // 'password.numbers' => 'Debes incluir al menos un número.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ])->validate();

        // 3. Consulta a SQL Server (cat_personal)
        $empleado = DB::connection('sqlsrv_reloj')
            ->table('cat_personal')
            ->where('curp', $input['curp'])
            ->first();

        // 4. Validar que el empleado exista y esté activo en el sistema externo
        if (!$empleado || $empleado->activo != 1) {
            throw ValidationException::withMessages([
                'curp' => ['No se pudo realizar el registro porque el personal no se encuentra activo en la base de datos de Reloj.'],
            ]);
        }

        // 5. Concatenar nombre completo
        $nombreCompleto = trim("{$empleado->nombre} {$empleado->paterno} {$empleado->materno}");

        // 6. Crear el usuario en la base de datos local (MySQL)
        return DB::transaction(function () use ($input, $nombreCompleto) {
            return tap(User::create([
                'name' => $nombreCompleto,
                'email' => $input['email'],
                'curp' => $input['curp'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                // 7. Asignar rol (Spatie)
                $user->assignRole('usuario_normal');
            });
        });
    }
}