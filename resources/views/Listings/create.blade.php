@extends('layout', [
    'heading' => 'listing'
])

@section('content')
    <div>
        <form method="POST" action="{{Route('listings.store')}}">
            @csrf
            <div>
                <div>
                    <label for="product[name]">
                        Product Naam
                    </label>
                </div>
                <div>
                    <input name="product[name]" type="text" placeholder="Product Naam"/>
                </div>
                <div>
                    <label for="product[description]">
                        Product Omschrijving
                    </label>
                </div>
                <div>
                    <textarea name="product[description]" required placeholder="Product Naam"></textarea>
                </div>
                <div>
                    <select name="listing">
                        <option value="set">Vaste Prijs</option>
                        <option value="bidding">Bieden</option>
                        <option value="rental">Verhuur</option>
                    </select>
                </div>
                <div>
                    <label for="product[price]">
                        Product Prijs
                    </label>
                </div>
                <div>
                    <input name="product[price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
                </div>
                <div>
                    <label for="product[amount]">
                        Aantal te koop
                    </label>
                </div>
                <div>
                    <input name="product[amount]" type="number" min='1' required placeholder="0"/>
                </div>
                <div>
                    <input type="submit" value="Advertentie plaatsen"/>
                </div>
            </div>
        </form>
    </div>
@endsection
