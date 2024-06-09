<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PageSetting;
use App\Models\PageComponent;
use App\Models\Favorite;

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
            return redirect()->route('listings.index');
        } else {
            $settings = PageSetting::where('url', $customUrl)->first();
            $components = PageComponent::where('user_id', $settings->user->id)->get();

            $favorites = null;

            if(Auth::check()){
                $favorites =  Favorite::where('user_id', Auth::user()->id)->get();
            }

            return view('commercial.custom-landing', [
                'heading' => 'pagina van '.$settings->user->name,
                'settings' => $settings,
                'components' => $components,
                'favorites' => $favorites
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();;
         return redirect('/login')->with('message', 'Je bent uitgelogd');
    }

}
