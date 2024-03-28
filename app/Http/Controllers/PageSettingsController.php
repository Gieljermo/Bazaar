<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PageSetting;

class PageSettingsController extends Controller
{
    public function index($id)
    {
        $user = User::where('id', $id)->first();
        $settings = PageSetting::where('user_id', $user->id)->first();

        return view('commercial.page-settings', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request, $id){

        $validated = $request->validate([
            'home_url' => 'string|required'
        ]);

        $user = User::where('id', $id)->first();

        PageSetting::UpdateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'url' => $request->input('home_url'),
            ]
        );

        return back()->with('message', 'Custom landing pagina instellingen succesvol gewijzigd.');
    }
}
