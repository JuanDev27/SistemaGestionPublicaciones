<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'codigo_estudiantil' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:50',
                Rule::unique(User::class, 'codigo_estudiantil'),
            ],
            'programa_academico' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'correo'),
                function ($attribute, $value, $fail) {
                    if (!str_ends_with(strtolower($value), '@uniautonoma.edu.co')) {
                        $fail('El correo electrónico debe pertenecer obligatoriamente al dominio @uniautonoma.edu.co');
                    }
                },
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'nombres' => $input['name'],
            'apellidos' => $input['lastname'],
            'correo' => strtolower($input['email']),
            'telefono' => $input['phone'] ?? null,
            'password' => Hash::make($input['password']),
            'programa_academico' => $input['programa_academico'],
            'codigo_estudiantil' => $input['codigo_estudiantil'],
            'rol' => 'estudiante',
            'estado' => 'ACTIVO',
            'fecha_registro' => now(),
        ]);
    }
}
