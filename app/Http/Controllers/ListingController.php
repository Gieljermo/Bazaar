<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("Listings.index");
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
            'product.price' => 'exclude_if:listing,bidding|required|numeric',
            'listing' => 'required',
            'product.amount' => 'required'
        ]);

        $product = Product::create([
            'product_name' => $request->input('product.name'),
            'description' => $request->input('product.description'),
            'price' => $request->input('product.price'),
            'amount' => $request->input('product.amount'),
        ]);

        Listing::create([
            'product_id' => $product->id,
            'user_id' => 1, //Zet dit op ingelogde user
            'type' => $request->input('listing')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        //
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
}
