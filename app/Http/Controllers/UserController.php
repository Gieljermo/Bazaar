<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        switch (Auth::user()->role_id){
            case 1:
                    return redirect()->route('customer.index');
                break;
            case 2:
                    return redirect()->route('proprietary.index');
                break;
            case 3:
                 return redirect()->route('commercial.index');
                break;
            case 4:
                    return redirect()->route('admin.index');
                break;
        }
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
                'user' => $user
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id)->fill($request->all());
        $user->role_id =
            ($request->input('type_user') == 'on') ?    1 : (($request->input('type_user') == 'particuliere adverteerder') ? 2 : 3);

        $user->save();

        return redirect()->route('users.edit', ['user' => $user])
            ->with('success_message', 'Het profiel is succesvol geüpdated');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
