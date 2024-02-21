@extends('layout', [
    'title' => 'Advertenties'
])
@section('content')
    @foreach ($listings as $listing)
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="..." alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{$listing->product->product_name}}</h5>
                <p class="card-text">{{$listing->product->description}}</p>
                @if (isset($listing->price_from))
                    <p class="card-text">Bieden vanaf: &euro;{{$listing->price_from}}</p>
                @else
                    <p class="card-text">&euro;{{$listing->price}}</p>
                @endif
                <a href="{{Route('listings.show', $listing->id)}}" class="btn btn-primary">Advertentie bekijken</a>
            </div>
        </div>
    @endforeach
@endsection
