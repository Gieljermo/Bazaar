@extends('layout', [
    'title' => ''
])
@section('content')
    <div>
        <p>{{$listing->product->product_name}}</p>
        <p>{{$listing->product->description}}</p>
        @if (isset($listing->price_from))
            <p>Bieden vanaf: &euro;{{$listing->price_from}}</p>
            <div class="card">
                <div class="card-body">
                    <p>100</p>
                    <p>100</p>
                    <p>100</p>
                </div>
            </div>
            <form method="POST" action="">
                <input class="form-control border-black" name="listing[price]" type="text" placeholder="0,00"/>
                <input class="btn btn-primary" type="submit" value="Bod plaatsen"/>
            </form>
        @else
            <p>&euro;{{$listing->price}}</p>
        @endif
    </div>
@endsection
