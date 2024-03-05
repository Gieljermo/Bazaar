<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //
    public function index()
    {
        //
    }

    public function addFavoriteProduct($productId){
        try {
            $favorite = new Favorite();

            $favorite->user_id = Auth::user()->id;
            $favorite->product_id = $productId;

            $favorite->save();

            return redirect()->back();
        }
        catch (\Exception $e){
            return redirect()->back();
        }
    }

    public function getFavoriteProducts(){

        $products = Favorite::where('user_id', Auth::user()->id)
            ->with('product')
            ->cursorPaginate(4);

        return view('customer.favorite', ['heading' => 'Favorieten van '.Auth::user()->name.' '.Auth::user()->lastname],
            compact('products')
        );
    }


    public function removeFavoriteProducts($prodcutId){
        $favorite = Favorite::where('product_id', $prodcutId)->first();

        if($favorite){
            $favorite->delete();
        }

        return redirect()->route('customer.favorite');
    }
}
