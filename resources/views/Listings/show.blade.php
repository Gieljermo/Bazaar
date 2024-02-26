@extends('layout', [
    'title' => ''
])
@section('content')
<div class="d-flex justify-content-around flex-row g-5 w-50">
    <div class="left">
        <img href="#" alt="placeholder image">
    </div>
    <div class="right">
        <p>{{$listing->product->product_name}}</p>
        <p>{{$listing->product->description}}</p>
        @if ($listing->type == "bidding")
            <p>Bieden vanaf: &euro;{{$listing->price_from}}</p>
            <div class="card">
                <div class="card-body">
                    @foreach ($listing->bids as $bid)
                        <div class="d-flex flex-row">
                            <p>{{$bid->date}}</p>
                            <p>{{$bid->user->name}} {{$bid->user->lastname}}</p>
                            <p>{{$bid->price}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <form method="POST" action="{{Route('listing.bid')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <input class="form-control border-black" name="bid" type="text" placeholder="0,00"/>
                <input class="btn btn-primary" type="submit" value="Bod plaatsen" required/>
            </form>
        @elseif ($listing->type == "rental")
            <form method="POST" action="{{Route('listing.rent')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <div class="form-group mb-4">
                    <label for="rent_from">Start datum</label>
                    <input class="form-control" type="date" name="rent_from"/>
                </div>
                <div class="form-group mb-4">
                    <label for="rent_until">Eind datum</label>
                    <input class="form-control" type="date" name="rent_until"/>
                </div>
                <div class="form-group mb-4">
                    <input class="btn btn-primary" type="submit" value="Product Huren"/>
                </div>
            </form>
        @else
            <p>&euro;{{$listing->price}}</p>
            <form method="POST" action="{{Route('listing.buy')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <input class="btn btn-primary" type="submit" value="Product Kopen"/>
            </form>
        @endif
    </div>
</div>
@endsection
