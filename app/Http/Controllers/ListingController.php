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


class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = Listing::Where('purchase_id', null)->get();
        return view("Listings.index", [
            "listings" => $listings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Listings.create");
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
            'listing.amount' => 'required',
            'listing.type' => 'required',
        ]);

        $product = Product::create([
            'product_name' => $request->input('product.name'),
            'description' => $request->input('product.description'),
        ]);

        $listing = new Listing();
        $listing->product_id = $product->id;
        $listing->user_id = Auth::user()->id;
        $listing->type = $request->input('listing.type');

        if ($request->has('listing.bid-price')) {
            $listing->price_from = $request->input('listing.bid-price');
            $listing->bid_until = $request->input('listing.bid-until');
        } else if ($request->has('listing.price')) {
            $listing->price = $request->input('listing.price');
        } else if ($request->has('listing.rent-price')) {
            $listing->price = $request->input('listing.rent-price');
        }

        $listing->amount = $request->input('listing.amount');
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

        $validated = $request->validate([
            'bid' => "required|numeric|min:$listing->price_from",
        ]);

        Bid::create([
            'user_id' => Auth::user()->id,
            'listing_id' => $listing->id,
            'date' => Carbon::now(),
            'price' => $request->bid
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

        Rental::create([
            'user_id' => Auth::user()->id,
            'listing_id' => $request->listing,
            'from' => Carbon::now(),
            'until' => $request->bid
        ]);

        return redirect()->route('listings.index');
    }
}
