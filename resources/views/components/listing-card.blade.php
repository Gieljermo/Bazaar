@php
$foundFavorite = false;
@endphp

<div class="card-container">
    <div class="card">
        <div class="card-img-wrapper">
            <img class="p-1 card-img-top" src="{{$listing->getImageUrl()}}" alt="Card image cap">
        </div>
        <div class="card-body">
            <h5 class="card-title">{{$listing->product->product_name}}</h5>
            <p class="card-text card-description">{{$listing->product->description}}</p>
            @if ($listing->type == "bidding")
                <p class="card-text">Bieden tot: {{$listing->bid_until}}</p>
            @else
                <p class="card-text">&euro;{{$listing->price}}</p>
            @endif
            <a href="{{Route('listings.show', $listing->id)}}" id="link_{{$listing->product->id}}" class="btn btn-primary"> Advertentie bekijken</a>

            <div class="d-flex w-100 justify-content-end">
                @auth()
                    @foreach($favorites as $favorite)
                        @php $foundFavorite = false @endphp
                        @if($favorite->listing_id === $listing->id)
                            <form action="{{route('customer.delete.favorite', $listing->id)}}">
                                @csrf
                                <button class="icon-button"><i style="font-size: 24px"
                                                               class="bi bi-heart-fill"></i></button>
                            </form>
                            @php $foundFavorite = true @endphp
                            @break
                        @endif
                    @endforeach
                    @if($foundFavorite === false)
                        <form action="{{route('customer.add.favorite', $listing->id)}}">
                            @csrf
                            <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i>
                            </button>
                        </form>
                    @endif
                @endauth
                    @guest()
                        <form action="{{route('customer.add.favorite', $listing->id)}}">
                            @csrf
                            <button class="icon-button"><i style="font-size: 24px" class="bi bi-heart"></i>
                            </button>
                        </form>
                    @endguest()
            </div>
        </div>
    </div>
</div>
