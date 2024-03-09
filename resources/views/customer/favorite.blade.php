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
            <h3 class="text-uppercase">Het lijst sorteren</h3>
            <div class="form-group">
                <div>
                    <input type="radio" id="sort-standard" onclick="javascript:window.location.href='{{route('customer.favorites')}}'; return false"
                        {{($sortActive == 'standard') ? 'checked': ""}}>
                    <label class="form-label" for="sort-standard" style="font-size: 1.5em">Ongedaan maken</label>
                </div>
                @foreach($sorts as $sort)
                    <div>
                        <input type="radio" id="sort-{{$sort}}" onclick="javascript:window.location.href='{{route('customer.sort.favorites', $sortArray[$sort])}}'; return false"
                            {{($sortActive == $sortArray[$sort]) ? 'checked': ""}}>
                        <label class="form-label" for="sort-{{$sort}}" style="font-size: 1.5em">Sorteren op {{$sortArray[$sort]}}</label>
                    </div>
                @endforeach
            </div>
        </div>
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
