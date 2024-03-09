<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //

    private array $sort = ['sortByAsc', 'sortByDesc'];
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
            ->simplePaginate(4);

        return view('customer.favorite', [
            'heading' => 'Favorieten van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => 'standard',
        ],
            compact('products')
        );
    }

    public function sortFavoriteProducts($sort){

        $products = Favorite::select('favorites.*')->where('user_id', Auth::user()->id)
            ->with('product')
            ->join('products', 'favorites.product_id', '=', 'products.id')
            ->orderBy('product_name', $sort)
            ->simplePaginate(4);

        return view('customer.favorite', [
            'heading' => 'Favorieten van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => $sort
        ],
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

    public function getPurchaseHistory(){
        $purchases = Purchase::where('purchases.user_id', Auth::user()->id)
            ->with('listings.product')
            ->simplePaginate(4);

        return view('customer.history', [
            'heading' => 'Bestelling van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => 'standard',
        ],
            compact('purchases'));
    }

    public function sortPurchasedProducts($sort){
        $purchases = Purchase::select('purchases.*')->where('purchases.user_id', Auth::user()->id)
            ->with('listings.product')
            ->join('listings', 'purchases.id', '=', 'listings.purchase_id')
            ->join('products', 'products.id', '=', 'listings.product_id')
            ->orderBy('products.product_name', $sort)
            ->simplePaginate(4);

        return view('customer.history', [
            'heading' => 'Bestelling van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => $sort
        ],
            compact('purchases')
        );
    }
}
