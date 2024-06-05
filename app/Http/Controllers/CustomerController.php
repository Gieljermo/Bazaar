<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;

class CustomerController extends Controller
{
    //

    private array $sort = ['sortByAsc', 'sortByDesc'];
    public function index()
    {
        //
    }

    public function addFavoriteProduct($listingId){

        $favorite = new Favorite();

        $favorite->user_id = Auth::user()->id;
        $favorite->listing_id = $listingId;

        $favorite->save();

        return redirect()->back();
    }

    public function getFavoriteProducts(){

        $favorites = Favorite::where('favorites.user_id', Auth::user()->id)
        ->has('listing.product')
        ->simplePaginate(4);


        return view('customer.favorite', [
            'heading' => 'Favorieten van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => 'standard',
        ],
            compact('favorites')
        );
    }

    public function sortFavoriteProducts($sort){

        $favorites = Favorite::select('favorites.*')->where('favorites.user_id', Auth::user()->id)
            ->has('listing.product')
            ->join('listings', 'favorites.listing_id', '=', 'listings.id')
            ->join('products', 'listings.product_id', '=', 'products.id')
            ->orderBy('product_name', $sort)
            ->simplePaginate(4);

        return view('customer.favorite', [
            'heading' => 'Favorieten van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => $sort
        ],
            compact('favorites')
        );
    }

    public function removeFavoriteProducts($listingId){
        $favorite = Favorite::where([
            ['listing_id', $listingId],
            ['user_id', Auth::user()->id]
        ])->first();

        if($favorite){
            $favorite->delete();
        }

        return redirect()->back();
    }

    public function getPurchaseHistory(){
        $purchases = Purchase::select('*')->where('purchases.user_id', Auth::user()->id)
            ->simplePaginate(4);

        $reviews = Review::where('reviewer_id', Auth::user()->id)->get();

        return view('customer.history', [
            'heading' => 'Bestelling van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => 'standard',
            'reviews' => $reviews
        ],
            compact('purchases'));
    }

    public function sortPurchasedProducts($sort){
        $purchases = Purchase::select('purchases.*')->where('purchases.user_id', Auth::user()->id)
            ->has('listings.product')
            ->join('listings', 'purchases.id', '=', 'listings.purchase_id')
            ->join('products', 'products.id', '=', 'listings.product_id')
            ->orderBy('products.product_name', $sort)
            ->simplePaginate(4);

        $reviews = Review::where('reviewer_id', Auth::user()->id)->get();

        return view('customer.history', [
            'heading' => 'Bestelling van '.Auth::user()->name.' '.Auth::user()->lastname,
            'sorts' => $this->sort,
            'sortActive' => $sort,
            'reviews' => $reviews
        ],
            compact('purchases')
        );
    }

    public function createReview(Request $request){

        $review = new Review();
        $review->reviewer_id = Auth::user()->id;

        if($request['advertiser'] != null){
            $review->advertiser_id = $request['advertiser'];
            $review->listing_id = $request['listing'];
        }
        else{
            $review->listing_id = $request['listing'];
        }


        $review->text =$request['review'];
        $review->rating = $request['rating'];

        $review->save();

        return redirect()->back();
    }

}
