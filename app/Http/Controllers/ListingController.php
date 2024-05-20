<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Listing;
use App\Models\Bid;
use App\Models\Rental;
use App\Models\Purchase;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isEmpty;

class ListingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'delete']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Listing::where('ended', 0)->where('purchase_id', null);
        $favorites = null;

        if(Auth::check()){
            $favorites =  Favorite::where('user_id', Auth::user()->id)->get();
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);

        }

        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }
        // Paginate the final query
        $listings = $query->simplePaginate(12);
        return view("Listings.index", [
            "listings" => $listings,
            'favorites' => $favorites
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->role_id == 1){
            return back()->with('listing_error', 'Je moet een adverteerders account hebben om advertenties te kunnen plaatsen.');
        }
        return view("Listings.create", ['title' =>  'listing']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product.name' => 'required|string',
            'product.description' => 'string',
            'listing.price' => 'sometimes|required|numeric',
            'listing.bid-until' => 'sometimes|required',
            'listing.rent-price' => 'sometimes|required|numeric',
            'listing.type' => 'required',
        ]);


        $imagePath;
        if($request->file('listing.image')){
            $imagePath = $request->file('listing.image')->store('listings', 'public');
        }

        $product = Product::create([
            'product_name' => $request->input('product.name'),
            'description' => $request->input('product.description'),
        ]);

        $listing = new Listing();
        $listing->product_id = $product->id;
        $listing->user_id = Auth::user()->id;
        $listing->type = $request->input('listing.type');
        $listing->image = $imagePath;

        if ($request->has('listing.bid-price')) {
            $listing->price_from = $request->input('listing.bid-price');
            $listing->bid_until  = $request->input('listing.bid-until');
        } else if ($request->has('listing.price')) {
            $listing->price = $request->input('listing.price');
        } else if ($request->has('listing.rent-price')) {
            $listing->price = $request->input('listing.rent-price');
        }

        $listing->save();

        return redirect()->route('listings.index')->with('message', 'Advertentie succesvol toegevoegd.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $favorite = null;

        if(Auth::check()){
            $favorite =  Favorite::where([
                ['user_id', Auth::user()->id],
                ['listing_id', $listing->id ]
            ])->get();
        }

        $reviewsOfThisProduct = null;
        $reviewsOfAdvertiser = null;
        $averageRating = null;

        $reviewsOfAdvertiser = Review::where('advertiser_id', $listing->user->id)
            ->with('reviewer')
            ->get();

        foreach ($reviewsOfAdvertiser as $review){
            $averageRating += $review->rating;
        }
        if($averageRating != 0){
            $averageRating= round($averageRating / count($reviewsOfAdvertiser));
        }

        if($listing->type == 'rental'){
            $reviewsOfThisProduct = Review::where('listing_id', $listing->id)
                ->with('reviewer')
                ->get();
        }

        $hasRented = null;
        $hasPurchased = null;
        if(Auth::check()){
            $hasRented = Rental::where([
                'user_id' => Auth::user()->id,
                'listing_id' => $listing->id
            ])->get();

            $purchaseIds = Purchase::select('id')->where('user_id', Auth::user()->id)->get();
            foreach ($purchaseIds as $purchaseId){
                $hasPurchased = Listing::where([
                    'id' => $listing->id,
                    'purchase_id' => $purchaseId->id
                ]);
            }
        }

        return view('Listings.show', [
            'listing' => $listing,
            'favorite' => $favorite,
            'rentalReviews' => $reviewsOfThisProduct,
            'advertiserReviews' => $reviewsOfAdvertiser,
            'rating' => $averageRating,
            'hasRented' => $hasRented,
            'hasPurchased' => $hasPurchased,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }

    public function bid(Request $request){

        $listing = Listing::where('id', $request->listing)->first();
        $highestBid = $listing->highestBid() ? $listing->highestBid()->price : 0;

        $validated = $request->validate([
            'bod' => "required|numeric|gt:$highestBid",
        ]);


        Bid::create([
            'user_id' => Auth::user()->id,
            'listing_id' => $listing->id,
            'date' => Carbon::now(),
            'price' => $request->bod
        ]);

        return back()->with('succes', 'Bod succesvol geplaatst');
    }

    public function buy(Request $request){

        $purchase = Purchase::create([
            'user_id' => Auth::user()->id,
            'date' => Carbon::now(),
        ]);

        $listing = Listing::where('id', $request->listing)->first();
        $listing->purchase_id = $purchase->id;

        $listing->save();


        return redirect()->route('listings.index');
    }

    public function rent(Request $request){

        $validated = $request->validate([
            'rent_from' => "required|date",
            'rent_until' => "required|date",
        ]);

        $rent_from = Carbon::parse($request->rent_from);
        $rent_until = Carbon::parse($request->rent_until);

        Rental::create([
            'user_id' => Auth::user()->id,
            'listing_id' => $request->listing,
            'from' => $rent_from,
            'until' => $rent_until
        ]);

        return redirect()->route('listings.index');
    }
}
