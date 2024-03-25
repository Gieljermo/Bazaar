@extends('layout', [
    'title' => ''
])
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="listing-container d-flex justify-content-center flex-row g-5">
    <div class="left">
        <img src="{{$listing->getImageUrl()}}" alt="placeholder image">
    </div>
    <div class="right">
        <div class="d-flex">
            <h1>{{$listing->product->product_name}}</h1>
            @auth
                @if(!$favorite->isEmpty())
                    <form action="{{route('customer.delete.favorite', $listing->id)}}">
                        @csrf
                        <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart-fill"></i></button>
                    </form>
                @else
                    <form action="{{route('customer.add.favorite', $listing->id)}}">
                        @csrf
                        <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i></button>
                    </form>
                @endif
            @endauth
            @guest
                <form action="{{route('customer.add.favorite', $listing->id)}}">
                    @csrf
                    <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i></button>
                </form>
            @endguest
        </div>
        <p>{{$listing->product->description}}</p>
        <p>Aangeboden door: {{$listing->user->name}} {{$listing->user->lastname}}</p>
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
        @else
            <p>&euro;{{$listing->price}}</p>
            <form method="POST" action="{{Route('listing.buy')}}">
                @csrf
                <input type="hidden" name="listing" value="{{$listing->id}}"/>
                <input class="btn btn-primary" type="submit" value="Product Kopen"/>
            </form>
        @endif
        <div class='mt-4'>
            {!! QrCode::size(200)->generate(url()->current()) !!}
        </div>
    </div>
</div>
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
            beforeShowDay: disableDates
        });
    });
</script>
@endsection
