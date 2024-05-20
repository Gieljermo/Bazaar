<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class languageController extends Controller
{
    public function switchLanguage(Request $request){
        $language = $request->input('language');

        session(['language' => $language]);

        return back();
    }
}
