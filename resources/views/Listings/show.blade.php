@extends('layout', [
    'title' => '',
    'heading' => ''
])
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="listing-container d-flex justify-content-center flex-row g-5">
    <div class="left">
        <img id="listing-show-image" src="{{$listing->getImageUrl()}}" alt="placeholder image">
    </div>
    <div class="right">
        <div class="d-flex">
            <h1 id="product-name" >{{$listing->product->product_name}}</h1>
            @auth
                @if(!$favorite->isEmpty())
                    <form action="{{route('customer.delete.favorite', $listing->id)}}">
                        @csrf
                        <button id="favorite_button_{{$listing->id}}" class="icon-button"><i style="font-size: 24px" class="bi bi-heart-fill"></i></button>
                    </form>
                @else
                    <form action="{{route('customer.add.favorite', $listing->id)}}">
                        @csrf
                        <button id="favorite_button_{{$listing->id}}" class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i></button>
                    </form>
                @endif
            @endauth
            @guest
                <form action="{{route('customer.add.favorite', $listing->id)}}">
                    @csrf
                    <button id="favorite_button_{{$listing->id}}" class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i></button>
                </form>
            @endguest
        </div>
        <p>{{$listing->product->description}}</p>
        <p>Aangeboden door: {{$listing->user->name}} {{$listing->user->lastname}}</p>
        <div>
            <h5>Beoordeling voor de adverteerder</h5>
            @if($rating != null)
                @for($i = 0; $i < $rating; $i++)
                    <span><i class="fa fa-star text-warning"></i></span>
                @endfor
                @for($i = (5 - $rating); $i > 0; $i--)
                    <span><i class="fa fa-star"></i></span>
                @endfor
            @else
                @for($i = 0; $i < 5; $i++)
                    <span><i class="fa fa-star"></i></span>
                @endfor
            @endif
        </div>
        <p>
            <a class="text-uppercase" style="color:#0D6EFD; text-decoration: underline;text-underline: #0D6EFD; cursor: pointer; font-size: 18px;"
               data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ervaringen
            </a>
        </p>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-body">
                        @if(!$advertiserReviews->isEmpty())
                            <div class="review mt-3 p-2" style="max-height:25vh; overflow-y: scroll; ">
                                @foreach($advertiserReviews as $review)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-10">
                                                    <p>
                                                        <span
                                                            class="float-start"><strong>{{$review->reviewer->name}} {{$review->reviewer->lastname}}</strong></span>
                                                        @for($i = $review->rating; $i > 0; $i--)
                                                            <span class="float-end"><i
                                                                    class="text-warning fa fa-star"></i></span>
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
                                @endforeach
                            </div>
                        @else
                            <div>
                                <h5>Er zijn nog geen beoordeling voor deze adverteerder</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @if ($listing->type == "bidding")
            <p>Bieden vanaf: &euro;{{isset($listing->price_from) ? $listing->price_from : 0}}</p>
            <div class="d-flex gap-3">
                <p>Veiling loopt: </p>
                <p id="timer"></p>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    @foreach ($listing->bids as $bid)
                        <div class="d-flex flex-row gap-3">
                            <p>{{$bid->date}}</p>
                            <p>{{$bid->user->name}} {{$bid->user->lastname}}</p>
                            <p>&euro;{{$bid->price}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <form method="POST" action="{{Route('listing.bid')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <div class="form-group mb-4">
                    <input class="form-control border-black" name="bod" type="text" placeholder="0,00"/>
                </div>
                @error('bod')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
                <div class="form-group mb-4">
                    <input class="btn btn-primary" type="submit" value="Bod plaatsen" required/>
                </div>
            </form>
        @elseif ($listing->type == "rental")
            <form method="POST" action="{{Route('listing.rent')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <div class="form-group mb-4">
                    <label for="rent_from">Start datum</label>
                    <input class="form-control datepicker" type="text" name="rent_from"/>
                </div>
                <div class="form-group mb-4">
                    <label for="rent_until">Eind datum</label>
                    <input class="form-control datepicker" type="text" name="rent_until"/>
                </div>
                <div class="form-group mb-4">
                    <input class="btn btn-primary" type="submit" value="Product Huren"/>
                </div>
            </form>
            @auth()
                @if(!$hasRented->isEmpty())
                    <form action="{{route('customer.write.review')}}" method="POST">
                        @csrf
                        <div>
                            <h5 class="text-uppercase">Geef een review voor dit product</h5>
                        </div>
                        <div>
                            <span onclick="rate(1)"><i class="fa fa-star star"></i></span>
                            <span onclick="rate(2)"><i class="fa fa-star star"></i></span>
                            <span onclick="rate(3)"><i class="fa fa-star star"></i></span>
                            <span onclick="rate(4)"><i class="fa fa-star star"></i></span>
                            <span onclick="rate(5)"><i class="fa fa-star star"></i></span>
                            <input hidden name="rating" id="rating" type="text" required>
                            <input hidden name="listing" id="listing" type="text" value="{{$listing->id}}" required>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="review">Beschrijf jouw review:</label>
                            <textarea class="form-control" id="review" name="review" required></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <input class="btn btn-primary" type="submit" value="Plaats review"/>
                        </div>
                    </form>
                @endif
            @endauth
            @if(!$rentalReviews->isEmpty())
                <div class="review mt-3 p-2" style="max-height:25vh; overflow-y: scroll; ">
                    @foreach($rentalReviews as $review)
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
                    @endforeach
                </div>
            @else
                <div class="mt-2">
                    <h5 class="text-uppercase">Er zijn nog geen beoordelingen voor dit product</h5>
                </div>
            @endif
        @else
            <p>&euro;{{$listing->price}}</p>
            <form method="POST" action="{{Route('listing.buy')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <input class="btn btn-primary" id="buy-product" type="submit" value="Product Kopen"/>
            </form>
        @endif
        <div class='mt-4'>
            {!! QrCode::size(200)->generate(url()->current()) !!}
        </div>
    </div>
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
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{ $listing->bid_until }}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="timer"
        document.getElementById("timer").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "Veiling afgelopen.";
        }
    }, 1000);

    var occupiedDates = @json($listing->rentals);
</script>
<script>
    $(function() {
        function disableDates(date) {
            for (var i = 0; i < occupiedDates.length; i++) {
                var start = new Date(occupiedDates[i].from);
                var end = new Date(occupiedDates[i].until);

                if (date >= start && date <= end) {
                    return [false];
                }
            }
            return [true];
        }

        $(".datepicker").datepicker({
            beforeShowDay: disableDates,
            minDate: 0
        });
    });
</script>
@endsection
