@extends('layout', [
    'title' => 'Advertenties',
    'heading' => 'Advertenties'
])


@php
$foundFavorite = false;
@endphp

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-3">
            <form id="filterForm" action="{{ route('listings.index') }}" method="GET">
                <div class="d-flex flex-column">
                    <label>Filter op Type:</label>
                    <select class="w-25" name="type" id="type" onchange="this.form.submit()">
                        <option value="" >Geen filter</option>
                        <option value="bidding" @if(request('type')=='bidding') selected @endif>Veiling</option>
                        <option value="rental" @if(request('type')=='rental') selected @endif>Verhuur</option>
                        <option value="set" @if(request('type')=='set') selected @endif>Vaste Prijs</option>
                    </select>
                </div>

                <fieldset class="d-flex flex-column">
                    <legend>Sorteren:</legend>
                    <label>
                        <input checked type="radio" name="sort" value="" onchange="this.form.submit()">
                        Geen filter
                    </label>

                    <label>
                        <input type="radio" @if(request('sort')=='price_asc') checked @endif name="sort" value="price_asc" onchange="this.form.submit()">
                        Prijs (Laag naar Hoog)
                    </label>

                    <label>
                        <input type="radio" @if(request('sort')=='price_desc') checked @endif name="sort" value="price_desc" onchange="this.form.submit()">
                        Price (Hoog naar Laag)
                    </label>
                </fieldset>
            </form>
        </div>
        <div class="w-50 d-flex justify-content-start flex-wrap ">
            @foreach ($listings as $listing)
            <div class="card-container  ">
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
                        <a href="{{Route('listings.show', $listing->id)}}" id="link_{{$listing->product->id}}" class="btn btn-primary"> Advertentie bekijken</a>

                        <div class="d-flex w-100 justify-content-end">
                            @auth()
                                @foreach($favorites as $favorite)
                                    @php $foundFavorite = false @endphp
                                    @if($favorite->listing_id === $listing->id)
                                        <form action="{{route('customer.delete.favorite', $listing->id)}}">
                                            @csrf
                                            <button class="icon-button"><i style="font-size: 24px"
                                                                           class="bi bi-heart-fill"></i></button>
                                        </form>
                                        @php $foundFavorite = true @endphp
                                        @break
                                    @endif
                                @endforeach
                                @if($foundFavorite === false)
                                    <form action="{{route('customer.add.favorite', $listing->id)}}">
                                        @csrf
                                        <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                                @guest()
                                    <form action="{{route('customer.add.favorite', $listing->id)}}">
                                        @csrf
                                        <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i>
                                        </button>
                                    </form>
                                @endguest()
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="page-link mt-3 ms-2 w-50">
        {{$listings->links()}}
    </div>
@endsection
