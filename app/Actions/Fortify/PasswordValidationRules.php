<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Rules\Password as FortifyPassword;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return [
        'required',
        'string',
        'min:8',
        'max:15',
        'confirmed',
        // En lugar de default(), usamos una nueva instancia
        (new FortifyPassword)
            ->requireUppercase() // Requiere al menos una mayúscula
            ->requireNumeric()   // Requiere al menos un número
            ->requireSpecialCharacter(), // Requiere un símbolo (opcional)
        ];
    }
}
