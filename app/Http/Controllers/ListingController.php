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
use App\Rules\CsvValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Log;

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
        $listingProduct = Listing::where("id", $listing->id)->with("product")->first();

        return view("Listings.listing_edit", [
            'listing' => $listingProduct,
            'heading' => "Wijzig advertentie: " . $listingProduct->product->product_name
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
        $validated = $request->validate([
            'product.name' => 'required|string',
            'product.description' => 'string',
            'listing.price' => 'sometimes|required|numeric',
            'listing.bid-until' => 'sometimes|required',
            'listing.rent-price' => 'sometimes|required|numeric',
        ]);

        $currentListing = Listing::find($listing->id);

        if ($currentListing){
            if ($request->has('listing.bid-price')) {
                $listing->price_from = $request->input('listing.bid-price');
                $listing->bid_until = $request->input('listing.bid-until');
            } else if ($request->has('listing.price')) {
                $listing->price = $request->input('listing.price');
            } else if ($request->has('listing.rent-price')) {
                $listing->price = $request->input('listing.rent-price');
            }

            if($request->file('listing.image') != null) $listing->image = $request->file('listing.image')->store('listings', 'public');


            $product = Product::find($currentListing->product_id);
            if($product){
                $product->product_name = $request->input('product.name');
                $product->description = $request->input('product.description');

                $product->save();
            }

            $listing->save();
            return redirect()->route("advert.listings")->with("success", "De advertentie  is geupdate");
        }
        else{
            return  redirect()->route("advert.listings")->with("failed", "De advertentie  kon niet worden geupdate");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
         $listing = Listing::find($listing->id);

         if ($listing){
             $product = $listing->product;

             $listing->delete();

             if($product){
                 $product->delete();
             }
             return back()->with("success", "De advertentie  is verwijderd");
         }
         else{
             return back()->with("failed", "De advertentie  kon niet verwijderd worden");
         }


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

    public function showAdvertiserListings(Request $request){

        $listings= Listing::where("user_id", Auth::user()->id)
            ->with("product");

        if ($request->type != null){
            $listings->where("type", $request->type);
        }

        if($request->sort != null && $request->has('sort')){
            $listings = $listings->orderby('price', $request->sort);
        }

        $listings = $listings->simplePaginate(10);
        return view("Listings.listing_list", [
            'listings' => $listings
        ]);
    }

    public function uploadCsvFile(Request $request){

        $request->validate([
            'csv_file' => ['required','file', new CsvValidation()]
        ]);

        $file = $request->file('csv_file');
        $fileContents = file($file->getPathname());
        $skipHeader = true;
        foreach ($fileContents as $line) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }

            $getCsv = str_getcsv($line);

            $product = Product::create([
                'product_name' => $getCsv[0],
                'description' => $getCsv[1],
            ]);

            Listing::create([
                "product_id" => $product->id,
                "user_id" => Auth::user()->id,
                "type" => $getCsv[2],
                (($getCsv[2] == "bidding") ? "price_from" : "price") => $getCsv[3],
            ]);
        }

        return redirect()->back()->with('success', 'CSV bestand is succesvol geupload.');

    }

    public function exportToCsvFile(){

        $listings = Listing::where("user_id",Auth::user()->id)->with("product")->get();

        $fileName = "export_product_".Auth::user()->name.".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'product_name',
            'description',
            'type',
            'price',
        ]);

        foreach ($listings as $listing) {
            fputcsv($handle, [
                $listing->product->product_name,
                $listing->product->description,
                $listing->type,
                $listing->price
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
  
    public function autocomplete(Request $request)
    {

        
        $searchResults = Product::search($request->input('query'))->get();
        $productIds = $searchResults->pluck('id');

        $idsArray = explode(',', $request->input('idList'));
        

        $listings = Listing::whereNotIn('id', $idsArray)
            ->where('user_id', Auth::user()->id)
            ->whereIn('product_id', $productIds)
            ->get();


        return view('partials.page-builder.listing-list', compact('listings'))->render();
    }
}
