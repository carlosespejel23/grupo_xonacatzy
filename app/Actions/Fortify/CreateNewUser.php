<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'apPaterno' => ['required', 'string', 'max:255'],
            'apMaterno' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:10'],
            'tipoUsuario' => ['required', 'string', 'in:Usuario,Administrador'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'nombre' => $input['nombre'],
            'apPaterno' => $input['apPaterno'],
            'apMaterno' => $input['apMaterno'],
            'telefono' => $input['telefono'],
            'tipoUsuario' => $input['tipoUsuario'],
            'email' => $input['email'],
            'password' => Hash::make('123456789'),
        ]);
    }
}
