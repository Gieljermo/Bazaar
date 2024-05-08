<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;

class PageBuilderController extends Controller
{
    public function index(){

        $components = PageComponent::where('user_id', Auth::user()->id)->get();
        // $listings = Listing::where('user_id', Auth::user()->id)->get();
        $listings = Listing::All();

        return view('commercial.page-builder', [
            'heading' => 'landingpagina bouwer',
            'components' => $components,
            'listings' => $listings,
        ]);
    }

    public function store(Request $request){



        foreach($request->input('component') as $component){
            PageComponent::Create([
                'user_id' => Auth::user()->id,
                'header' => $component['header'],
                'text' => $component['text'],
            ]);
        }

        return back();
    }
}
