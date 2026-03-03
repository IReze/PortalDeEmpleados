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

    public function create(array $input): User
    {
        // 1. Validación de formato inicial (Para evitar procesar basura)
        Validator::make($input, [
            'curp' => ['required', 'string', 'size:18'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        // 2. Normalizar CURP (Mayúsculas y sin espacios)
        $curpNormalizada = strtoupper(str_replace(' ', '', $input['curp']));

       // Validamos que la CURP no esté repetida en nuestro MySQL
    $existe = User::where('curp', $curpNormalizada)->exists();
    if ($existe) {
    throw ValidationException::withMessages(['curp' => ['Esta CURP ya está registrada.']]);
    }

        // 4. Consulta a SQL Server (cat_personal)
        $empleado = DB::connection('sqlsrv_reloj')
            ->table('cat_personal')
            ->where('curp', $curpNormalizada) // Usamos la normalizada
            ->first();

        // 5. Validar que el empleado exista y esté activo
        if (!$empleado || $empleado->activo != 1) {
            throw ValidationException::withMessages([
                'curp' => ['No se pudo registrar porque el usuario no se encuentra activo en el sistema.'],
            ]);
        }

        // 6. Concatenar nombre completo desde SQL Server
        $nombreCompleto = trim("{$empleado->nombre} {$empleado->paterno} {$empleado->materno}");

        // 7. Crear el usuario 
      return User::create([
    'name' => $nombreCompleto,
    'email' => $input['email'],
    'curp' => $curpNormalizada, // <--- Guardamos la CURP real
    'password' => Hash::make($input['password']),
        ]);
        }
}
