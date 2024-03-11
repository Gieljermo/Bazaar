<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Bid;
use App\Models\Rental;
use App\Models\Purchase;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'delete']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listing::Where('ended', 0)->paginate(2);
        return view("Listings.index", [
            "listings" => $listings,
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
            $listing->bid_until = $request->input('listing.bid-until');
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

        return view('Listings.show', [
            'listing' => $listing,
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
