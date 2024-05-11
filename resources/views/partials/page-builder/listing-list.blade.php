@foreach ($listings as $listing)
<div class="listing-option" data-id="{{$listing->id}}">
    <img src="{{$listing->getImageUrl()}}" alt="listing foto">
    <p class="listing-name">{{$listing->product->product_name}}</p>
    <p>{{$listing->price}}</p>
</div>
@endforeach