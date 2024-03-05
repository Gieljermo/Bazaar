@extends('layout', [
    'title' => 'favorieten'
])

@section('content')
    <div class="col">

    </div>
    <div class="col-4">
        @if($products)
            @foreach($products as $favorite)
                <a href="" style="text-decoration: none; color: black">
                    <div style="" class="p-4 ps-3 pe-3  m-2 border border-dark border-1 rounded">
                        <p style="float: right">€{{ $favorite->product->price . ',00' }}</p>
                        <h4 class="text-uppercase">{{ $favorite->product->product_name }}</h4>
                        <p style="font-size: 1.2em">{{ $favorite->product->description }}</p>
                        <a href="{{ route('customer.delete.favorite', $favorite->product->id) }}" class="text-uppercase" style="float: right">Verwijderen</a>
                    </div>
                </a>
            @endforeach
        <div class="page-link mt-3 ms-2">
            {{$products->links()}}
        </div>
        @else
            <div class="text-center">
                <h2>Je heb geen favorieten toegevoegd</h2>
            </div>
        @endif
    </div>
    <div class="col">

    </div>
@endsection
