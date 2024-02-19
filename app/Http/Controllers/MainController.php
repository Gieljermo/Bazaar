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
        return view('index', ['heading' => 'Home']);
    }

    public function logout(Request $request){
        Auth::logout();;
         return redirect('/login')->with('message', 'Je bent uitgeleogd');
    }

}
