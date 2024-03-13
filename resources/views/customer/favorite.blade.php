@extends('layout', [
    'title' => 'favorieten'
])

@php
    $sortArray = [
        'sortByAsc' => 'asc',
        'sortByDesc' => 'desc'
];

@endphp

@section('content')
    <div class="col ms-5 mt-5">
        <div>
            <h3 class="text-uppercase">Sorteer de lijst</h3>
            <div class="form-group">
                <div>
                    <input type="radio" id="sort-standard" onclick="javascript:window.location.href='{{route('customer.favorites')}}'; return false"
                        {{($sortActive == 'standard') ? 'checked': ""}}>
                    <label class="form-label" for="sort-standard" style="font-size: 1.5em">Maak ongedaan</label>
                </div>
                @foreach($sorts as $sort)
                    <div>
                        <input type="radio" id="sort-{{$sort}}" onclick="javascript:window.location.href='{{route('customer.sort.favorites', $sortArray[$sort])}}'; return false"
                            {{($sortActive == $sortArray[$sort]) ? 'checked': ""}}>
                        <label class="form-label" for="sort-{{$sort}}" style="font-size: 1.5em">{{($sortArray[$sort] === 'asc') ? 'Oplopend naam sorteren': 'Aflopend naam sorteren'}}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-4">
        @if($favorites->isEmpty())
            <div class="text-center me-5">
                <h3>Er zijn geen favorieten toegevoegd.</h3>
            </div>
        @else
            @foreach($favorites as $favorite)
                <a href="{{Route('listings.show', $favorite->listing->id)}}" style="text-decoration: none; color: black">
                    <div class="p-4 ps-3 pe-3 m-2 border border-dark border-1 rounded">
                        @if($favorite->listing->type === 'set')
                            <p style="float: right">€{{ $favorite->listing->price }}</p>
                        @elseif($favorite->listing->type === 'bidding')
                            <p style="float: right">Bieden</p>
                        @else
                            <p style="float: right">Huren</p>
                        @endif
                        <h4 class="text-uppercase">{{ $favorite->listing->product->product_name }}</h4>
                        <p style="font-size: 1.2em">{{ $favorite->listing->product->description }}</p>
                        <a href="{{ route('customer.delete.favorite', $favorite->listing->id) }}" class="text-uppercase" style="float: right">Verwijderen</a>
                    </div>
                </a>
            @endforeach
            <div class="page-link mt-3 ms-2">
                {{ $favorites->links() }}
            </div>
        @endif
    </div>
    <div class="col">

    </div>
@endsection
