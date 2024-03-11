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
                        {{-- CHECK OF PRODUCT AL FAVORIET IS OF NIET (IF ELSE) --}}
                        {{-- geen favoriet --}}
                        <form action="">
                            @csrf
                            <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i></button>
                        </form>
                        {{-- al wel favoriet --}}
                        <form action="">
                            <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart-fill"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="page-link mt-3 ms-2 w-50">
        {{$listings->links()}}
    </div>
@endsection
