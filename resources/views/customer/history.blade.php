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
                    <label class="form-label" for="sort-standard" style="font-size: 1.5em">Sorteer ongedaan</label>
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
                <div style="text-decoration: none; color: black">
                    <div class="p-4 ps-3 pe-3 m-2 border border-dark border-1 rounded">
                        <p style="float: right">€{{ $purchase->listing->price }}</p>
                        <h4 class="text-uppercase">{{ $purchase->listing->product->product_name }}</h4>
                        <p style="font-size: 1.2em">{{ $purchase->listing->product->description }}</p>
                        <p>
                            <a class="text-uppercase review-link-{{$purchase->listing->id}}" style="color:#0D6EFD; text-decoration: underline; cursor: pointer; font-size: 18px;"
                                data-bs-toggle="modal"  data-bs-target="#exampleModal{{$purchase->listing->id}}" dusk="review-link-{{$purchase->listing->id}}">
                                Laat een review achter voor de adverteerder
                            </a>
                        </p>
                        @if(!$reviews->isEmpty())
                            @foreach($reviews as $review)
                                @if($review->listing_id === $purchase->listing->id)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-10">
                                                    <p>
                                                        <span class="float-start"><strong>{{$review->reviewer->name}} {{$review->reviewer->lastname}}</strong></span>
                                                        @for($i = $review->rating; $i > 0; $i--)
                                                            <span class="float-end"><i class="text-warning fa fa-star"></i></span>
                                                        @endfor
                                                    </p>
                                                    <div class="clearfix mb-2"></div>
                                                    <p>
                                                        {{$review->text}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @endif
                            @endforeach
                        @endif
                        <div class="modal fade" id="exampleModal{{$purchase->listing->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$purchase->listing->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        @if($reviews->isEmpty() || !$reviews->contains('listing_id', $purchase->listing->id))
                                            <form action="{{route('customer.write.review')}}" method="post">
                                                @csrf
                                                <div>
                                                    <h5 class="text-uppercase">Geef een review voor deze adverteerder</h5>
                                                </div>
                                                <div>
                                                    <span onclick="rate(1)"><i class="fa fa-star star"></i></span>
                                                    <span onclick="rate(2)"><i class="fa fa-star star"></i></span>
                                                    <span onclick="rate(3)"><i class="fa fa-star star"></i></span>
                                                    <span onclick="rate(4)"><i class="fa fa-star star"></i></span>
                                                    <span onclick="rate(5)"><i class="fa fa-star star"></i></span>
                                                    <input hidden name="rating" id="rating" type="text" required>
                                                    <input hidden name="advertiser" id="advertiser" type="text" value="{{$purchase->listing->user->id}}" required>
                                                    <input hidden name="listing" id="listing" type="text" value="{{$purchase->listing->id}}" required>
                                                </div>
                                                <div class="form-group d-flex flex-column">
                                                    <label for="review">Beschrijf jouw review:</label>
                                                    <textarea class="form-control" id="review" name="review" required></textarea>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <input id="submit-review" class="btn btn-primary" type="submit" value="Plaats review"/>
                                                </div>
                                            </form>
                                        @else
                                            <div>
                                                <h5 class="text-uppercase">Je hebt de adverteerder beordeeld voor dit product</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="page-link mt-3 ms-2">
                {{$purchases->links()}}
            </div>
        @endif
    </div>
    <div class="col">

    </div>
    <script>
        let rating = document.getElementById('rating');
        let stars = document.getElementsByClassName('star');
        function rate(n){
            remove()
            for(let i = 0; i < n; i++){
                stars[i].classList.add('text-warning')
            }
            rating.value = n;
        }
        function remove() {
            let stars = document.getElementsByClassName('star');
            let i = 0;
            while (i < 5){
                if(stars[i].classList.contains('text-warning')){
                    stars[i].classList.remove('text-warning')
                }
                i++
            }
        }
    </script>
@endsection
