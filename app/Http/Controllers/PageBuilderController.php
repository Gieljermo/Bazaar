<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;
use App\Models\ComponentProduct;

class PageBuilderController extends Controller
{
    public function index(){

        $components = PageComponent::where('user_id', Auth::user()->id)->get();
        $listings = Listing::where('user_id', Auth::user()->id)->get();

        return view('commercial.page-builder', [
            'heading' => 'landingpagina bouwer',
            'components' => $components,
            'listings' => $listings,
        ]);
    }

    public function store(Request $request){



        foreach($request->input('component') as $component){


            $newComponent = PageComponent::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'header' => $component['header']
                ],
                [
                    'text' => $component['text']
                ]
            );

            $productIds = $component['product'] ?? null;
            
            $newComponent->listings()->sync($productIds);
        }

        return back();
    }

    public function getListingPartial(){
        $listings = Listing::where('user_id', Auth::user()->id)->get();
        return view('partials.page-builder.listing-list', compact('listings'))->render();
    }
}
