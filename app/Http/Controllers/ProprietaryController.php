<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProprietaryController extends Controller
{
    //
    public function index()
    {
        //
        return view('proprietary.index', ['heading' => 'Welkom '. Auth::user()->name]);
    }
}
