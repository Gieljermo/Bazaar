<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role_id === 4){
            return redirect()->route('admin.index');
        }

        $latestAdvertisements = Listing::with('product')->orderByDesc('id')->take(3)->get();

        return view('index', ['heading' => 'Welkom bij de Bazaar'],
            compact('latestAdvertisements'));
    }

    public function logout(Request $request){
        Auth::logout();;
         return redirect('/login')->with('message', 'Je bent uitgelogd');
    }

}
