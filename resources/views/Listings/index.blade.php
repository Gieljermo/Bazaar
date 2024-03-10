@extends('layout', [
    'title' => 'Advertenties',
    'heading' => 'Advertenties'
])

@section('content')
    <div class="w-50 d-flex justify-content-start flex-wrap">
        @foreach ($listings as $listing)
        <div class="card-container">
            <div class="card" style="width: 18rem;">
                <img class="p-1 card-img-top" src="{{$listing->getImageUrl()}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$listing->product->product_name}}</h5>
                    <p class="card-text">{{$listing->product->description}}</p>
                    @if ($listing->type == "bidding")
                        <p class="card-text">Bieden tot: {{$listing->bid_until}}</p>
                    @else
                        <p class="card-text">&euro;{{$listing->price}}</p>
                    @endif
                    <a href="{{Route('listings.show', $listing->id)}}" class="btn btn-primary">Advertentie bekijken</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
