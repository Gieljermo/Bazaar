<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PageSetting;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($customUrl = null)
    {
        

        if (Auth::check() && Auth::user()->role_id === 4){
            return redirect()->route('admin.index');
        }

        if($customUrl == null){
            return view('index', ['heading' => 'Welkom bij de Bazaar']);
        } else {
            $settings = PageSetting::where('url', $customUrl)->first();
            return view('commercial.custom-landing', [
                'heading' => 'pagina van '.$settings->user->name,
                'settings' => $settings
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();;
         return redirect('/login')->with('message', 'Je bent uitgelogd');
    }

}
