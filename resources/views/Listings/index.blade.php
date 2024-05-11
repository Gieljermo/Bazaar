@extends('layout', [
    'title' => 'Advertenties',
    'heading' => 'Advertenties'
])



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
                @include('components.listing-card', ['listing' => $listing, 'favorites' => $favorites])
            @endforeach
        </div>
    </div>
    <div class="page-link mt-3 ms-2 w-50">
        {{$listings->links()}}
    </div>
@endsection
