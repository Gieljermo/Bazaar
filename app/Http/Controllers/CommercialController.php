<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommercialController extends Controller
{
    //
    public function index()
    {
        //
        return view('commercial.index', ['heading' => 'Welkom '. Auth::user()->name]);
    }
}
