@extends('layout', [
    'title' => 'Advertenties',
    'heading' => 'Advertenties'
])

@section('content')
    @if(session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif
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
                    <a href="{{Route('listings.show', $listing->id)}}" class="btn btn-primary"> Advertentie bekijken</a>

                    <div class="d-flex w-100 justify-content-end">                
                        {{-- CHECK OF PRODUCT AL FAVORIET IS --}}
                        {{-- <a href="{{Route('listings.favorite', $listing->id)}}"> <i style="font-size: 24px" class="bi bi-heart"></i></a> --}}
                        {{-- <a href="{{Route('listings.unfoavorite', $listing->id)}}"> <i style="font-size: 24px" class="bi bi-heart-fill"></i></a> --}}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
