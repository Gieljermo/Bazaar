@extends('layout', [
    'title' => 'Bestelling geschiedenis'
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
                    <input type="radio" id="sort-standard" onclick="javascript:window.location.href='{{route('customer.purchases')}}'; return false"
                        {{($sortActive == 'standard') ? 'checked': ""}}>
                    <label class="form-label" for="sort-standard" style="font-size: 1.5em">Maak ongedaan</label>
                </div>
                @foreach($sorts as $sort)
                    <div>
                        <input type="radio" id="sort-{{$sort}}" onclick="javascript:window.location.href='{{route('customer.sort.purchases', $sortArray[$sort])}}'; return false"
                            {{($sortActive == $sortArray[$sort]) ? 'checked': ""}}>
                        <label class="form-label" for="sort-{{$sort}}" style="font-size: 1.5em">{{($sortArray[$sort] === 'asc') ? 'Oplopend naam sorteren ': 'Aflopend naam sorteren '}}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-4">
        @if($purchases->isEmpty())
            <div class="text-center me-5">
                <h3>Er zijn geen bestelling gemaakt.</h3>
            </div>
        @else
            @foreach($purchases as $purchase)
                @foreach($purchase->listings as $listing)
                    <a href="{{Route('listings.show', $listing->id)}}" style="text-decoration: none; color: black">
                        <div style="" class="p-4 ps-3 pe-3  m-2 border border-dark border-1 rounded">
                            <p style="float: right">€{{ $listing->price  }}</p>
                            <h4 class="text-uppercase">{{ $listing->product->product_name }}</h4>
                            <p style="font-size: 1.2em">{{ $listing->product->description }}</p>
                        </div>
                    </a>
                @endforeach
            @endforeach
            <div class="page-link mt-3 ms-2">
                {{$purchases->links()}}
            </div>
        @endif
    </div>
    <div class="col">

    </div>
@endsection
