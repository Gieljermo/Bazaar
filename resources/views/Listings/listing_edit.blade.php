@extends('layout', [
    'title' => 'wijzig product'
])

@section("content")
    <div class="d-flex justify-content-center">
        <form method="POST" action="{{Route('listings.update', $listing->id)}}" class="mt-4 w-25" enctype="multipart/form-data">
            @csrf
            @method("PATCH")
            <div class="form-group mb-4">
                <label class="mb-2 text-uppercase fw-bold" for="product[name]">
                    Product Naam
                </label>
                <input class="form-control border-black" name="product[name]" required type="text" value="{{$listing->product->product_name}}"/>
                @error('product.name')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="mb-2 text-uppercase fw-bold" for="product[description]">
                    Product Omschrijving
                </label>
                <textarea class="form-control border-black" name="product[description]" required >{{$listing->product->description}}</textarea>
                @error('product.description')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label class="mb-2 text-uppercase fw-bold" for="listing[image]">
                    Afbeelding
                </label>
                <input class="form-control border-black" required name="listing[image]" type="file" value="{{$listing->getImageUrl()}}"/>
                @error('listing.image')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
                @if($listing->image != null)
                <img class="float-end mt-2 card-img-top img-thumbnail mw-25" style="scale: 0.90" src="{{$listing->getImageUrl()}}" alt="Card image cap">
                @endif
            </div>
            @switch($listing->type)
                @case("set")
                    <div id="set" class="price form-group mb-4">
                        <label class="mb-2 text-uppercase fw-bold" for="listing[price]">
                            Product Prijs
                        </label>
                        <input class="form-control border-black" required name="listing[price]" type="text" pattern="[0-9]\.?*"  value="{{$listing->price}}"/>
                        @error('listing.price')
                            <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                        @enderror
                    </div>
                    @break
                @case("bidding")
                    <div id="bidding" class="price form-group mb-4">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="mb-2 text-uppercase fw-bold" for="listing[bid-price]">
                                    Bieden vanaf
                                </label>
                                <input class="form-control border-black" name="listing[bid-price]" type="text" pattern="[0-9]\.?*"  value="{{$listing->price_from}}"/>
                                @error('listing.bid-price')
                                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-uppercase fw-bold" for="listing[bid-until]">
                                    Bieden tot datum en tijd
                                </label>
                                <input class="form-control border-black" required name="listing[bid-until]" type="datetime-local" value="{{$listing->bid_until}}" />
                                @error('listing.bid_until')
                                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @break
                @case("rental")
                    <div id="rental" class="price form-group mb-4">
                        <label class="mb-2 text-uppercase fw-bold" for="listing[rent-price]">
                            Huurprijs
                        </label>
                        <input class="form-control border-black" required name="listing[rent-price]" type="text" pattern="[0-9]\.?*" value="{{$listing->price}}"/>
                        @error('listing.rent-price')
                            <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                        @enderror
                    </div>
                    @break
                @default
            @endswitch
            <div>
                <input type="submit" class="btn btn-primary" value="Update advertentie"/>
            </div>
        </form>
    </div>
@endsection
