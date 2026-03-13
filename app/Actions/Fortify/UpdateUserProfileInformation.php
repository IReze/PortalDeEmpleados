<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Valida y actualiza la información del perfil del usuario (Solo Email).
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // Eliminamos 'name' de la validación porque es readonly en la vista
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        // Si el email cambió y el sistema requiere verificación
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Guardamos únicamente el email para evitar errores con los campos protegidos
            $user->forceFill([
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Actualiza la información del usuario verificado.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
