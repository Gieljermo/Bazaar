@extends('layout', [
    'title' => 'Advertentie plaatsen',
    'heading' => 'Advertentie plaatsen'
])

@section('content')
<div class="d-flex justify-content-center">
    <form method="POST" action="{{Route('listings.store')}}" class="mt-4 w-25" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[name]">
                Product Naam
            </label>
            <input class="form-control border-black" name="product[name]" required type="text" placeholder="Product Naam"/>
            @error('product.name')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[description]">
                Product Omschrijving
            </label>
            <textarea class="form-control border-black" name="product[description]" required placeholder="Product Naam"></textarea>
            @error('product.description')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[image]">
                Afbeelding
            </label>
            <input class="form-control border-black" required name="listing[image]" type="file"/>
            @error('listing.image')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[description]">
                Type advertentie
            </label>
            <select id='listing-select' class="form-select border-black" name="listing[type]">
                <option value="" disabled selected>Kies een type advertentie</option>
                <option value="set">Vaste Prijs</option>
                <option value="bidding">Bieden</option>
                <option value="rental">Verhuur</option>
            </select>
            @error('listing.type')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div id="set" class="d-none price form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[price]">
                Product Prijs
            </label>
            <input class="form-control border-black" required name="listing[price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
            @error('listing.price')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div id="bidding" class="d-none price form-group mb-4">
            <div class="mb-3">
                <div class="mb-3">
                    <label class="mb-2 text-uppercase fw-bold" for="listing[bid-price]">
                        Bieden vanaf
                    </label>
                        <input class="form-control border-black" name="listing[bid-price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
                    @error('listing.bid-price')
                        <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="mb-2 text-uppercase fw-bold" for="listing[bid-until]">
                        Bieden tot datum en tijd
                    </label>
                    <input class="form-control border-black" id="bid-until" required name="listing[bid-until]" type="datetime-local"/>
                    @error('listing.bid_until')
                        <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div id="rental" class="d-none price form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[rent-price]">
                Huurprijs
            </label>
            <input class="form-control border-black" required name="listing[rent-price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
            @error('listing.rent-price')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <input type="submit" value="Advertentie plaatsen"/>
        </div>
    </form>
</div>

<script>
    let listingTypeSelect = document.getElementById('listing-select');

    listingTypeSelect.addEventListener('change', (event) => {
        let priceInputcontainers = document.querySelectorAll('.price');
        priceInputcontainers.forEach((container) => {
            container.classList.add('d-none')
            let inputs = container.querySelectorAll('input');
            inputs.forEach((input) => {
                input.disabled = true;
            })
        })

        let selectedInput = document.getElementById(event.target.value);
        selectedInput.classList.remove('d-none');
        let inputs = selectedInput.querySelectorAll('input');
        inputs.forEach((input) => {
            input.disabled = false;
        })
    })
</script>
@endsection
