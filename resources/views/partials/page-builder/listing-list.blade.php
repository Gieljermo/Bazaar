@foreach ($listings as $listing)
<div dusk='option_{{$listing->id}}' class="listing-option" data-id="{{$listing->id}}">
    <img class="listing-image" src="{{$listing->getImageUrl()}}" alt="listing foto">
    <p class="listing-name">{{$listing->product->product_name}}</p>
    <p class="listing-price">&euro;{{$listing->price}}</p>
</div>
@endforeach