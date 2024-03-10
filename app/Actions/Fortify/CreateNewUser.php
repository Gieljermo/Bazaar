<?php

namespace App\Actions\Fortify;

use App\Models\Contract;
use App\Models\User;
use App\Models\Role;
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
            'street' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:3'],
            'postal_code' => ['required', 'string', 'max:6'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'lastname' => $input['lastname'],
            'street' => $input['street'],
            'house_number' => $input['house_number'],
            'postal_code' => $input['postal_code'],
            'role_id' =>
                ($input['type_user'] == 'on') ?    1 : (($input['type_user'] == 'particuliere adverteerder') ? 2 : 3),
            'email' => $input['email'],
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make($input['password']),
        ]);

        if((Role::find($user->role_id))->role_name === "commercial"){
            Contract::create([
                'user_id' => $user->id,
                'accepted' => false
            ]);
        }

        return $user;
    }
}
