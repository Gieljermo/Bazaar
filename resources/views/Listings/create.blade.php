@extends('layout')

@section('content')
<form method="POST" action="{{Route('listings.store')}}" class="mt-4">
    @csrf
    <div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[name]">
                Product Naam
            </label>
            <input class="form-control border-black" name="product[name]" type="text" placeholder="Product Naam"/>
        </div>
        <div>
            <label class="mb-2 text-uppercase fw-bold" for="product[description]">
                Product Omschrijving
            </label>
            <textarea class="form-control border-black" name="product[description]" required placeholder="Product Naam"></textarea>
        </div>
        <div class="form-group mb-4">
            <select class="form-control border-black" name="listing">
                <option value="set">Vaste Prijs</option>
                <option value="bidding">Bieden</option>
                <option value="rental">Verhuur</option>
            </select>
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[price]">
                Product Prijs
            </label>
            <input class="form-control border-black" name="product[price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[amount]">
                Aantal te koop
            </label>
            <input class="form-control border-black" name="product[amount]" type="number" min='1' required placeholder="0"/>
        </div>
        <div>
            <input type="submit" value="Advertentie plaatsen"/>
        </div>
    </div>
</form>
@endsection
