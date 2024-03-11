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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function getKey($userId){
        $user = User::Where('id', $userId)->first();

        $token = $user->createToken("api_key")->plainTextToken;

        return redirect()->route('users.edit', ['user' => $user])
            ->with('success_message', 'Api token gegenereerd');
    }

    public function getAll(){
        return response(User::All());
    }
}
