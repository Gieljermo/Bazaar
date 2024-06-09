<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('auth.profile',
            [
                'heading' => 'Welkom '. Auth::user()->name,
                'user' => $user,
                'token' => $user->tokens()->first()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $user = User::find($user->id)->fill($request->all());

        $user->role_id =
            ($request->input('type_user') == 'on') ?    1 : (($request->input('type_user') == 'particuliere adverteerder') ? 2 : 3);

        if((Role::find($user->role_id))->role_name === "commercial" && !(Contract::where('user_id', $user->id)->exists())){
            Contract::insert([
                'user_id' => $user->id,
                'accepted' => false
            ]);
        }

        $user->save();

        return redirect()->route('users.edit', ['user' => $user])
            ->with('success_message', 'Het profiel is succesvol geüpdate');


    }

    public function getKey($userId){
        $user = User::Where('id', $userId)->first();

        $token = $user->createToken("api_key")->plainTextToken;

        return redirect()->route('users.edit', ['user' => $user])
            ->with('success_message', 'Api token gegenereerd bewaar deze goed.')
            ->with('token', "token: ".$token);
    }

    public function getAll(){
        return response(User::All());
    }
}
