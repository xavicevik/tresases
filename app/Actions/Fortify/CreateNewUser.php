<?php

namespace App\Actions\Fortify;

use App\Models\Cliente;
use App\Models\Team;
use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // Creación de Cliente
        if ($input['idrol'] == 2) {
            Validator::make($input, [
                'nombre' => ['required', 'string', 'max:255'],
                'apellido' => ['required', 'string', 'max:255'],
                'correo' => ['required', 'string', 'email', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:clientes'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            return DB::transaction(function () use ($input) {
                return tap(Cliente::create([
                    'nombre' => $input['nombre'],
                    'apellido' => $input['apellido'],
                    'username' => $input['username'],
                    'correo' => $input['correo'],
                    'idrol' => $input['idrol'],
                    'estado' => true,
                    'password' => Hash::make($input['password']),
                ]));
            });
        } elseif ($input['idrol'] == 5) {
            Validator::make($input, [
                'nombre' => ['required', 'string', 'max:255'],
                'apellido' => ['required', 'string', 'max:255'],
                'correo' => ['required', 'string', 'email', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:vendedors'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            return DB::transaction(function () use ($input) {
                return tap(User::create([
                    'nombre' => $input['nombre'],
                    'apellido' => $input['apellido'],
                    'username' => $input['username'],
                    'correo' => $input['correo'],
                    'idrol' => $input['idrol'],
                    'estado' => true,
                    'password' => Hash::make($input['password']),
                ]));
            });
        } else {
            Validator::make($input, [
                'nombre' => ['required', 'string', 'max:255'],
                'apellido' => ['required', 'string', 'max:255'],
                'correo' => ['required', 'string', 'email', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            return DB::transaction(function () use ($input) {
                return tap(User::create([
                    'nombre' => $input['nombre'],
                    'apellido' => $input['apellido'],
                    'username' => $input['username'],
                    'correo' => $input['correo'],
                    'idrol' => $input['idrol'],
                    'estado' => true,
                    'password' => Hash::make($input['password']),
                ]), function (User $user) {
                    $this->createTeam($user);
                });
            });
        }
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->nombre, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
