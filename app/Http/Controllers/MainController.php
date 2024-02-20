<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::check()){
            return redirect()->route('user.index');
        }
        return view('index', ['heading' => 'Welkom bij de Bazaar']);
    }

    public function logout(Request $request){
        Auth::logout();;
         return redirect('/login')->with('message', 'Je bent uitgelogd');
    }

}
