@extends('layout', [
    'title' => 'Advertentie plaatsen'
])

@section('content')
<div class="d-flex justify-content-center">
    <form method="POST" action="{{Route('listings.store')}}" class="mt-4 w-25">
        @csrf
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[name]">
                Product Naam
            </label>
            <input class="form-control border-black" name="product[name]" type="text" placeholder="Product Naam"/>
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="product[description]">
                Product Omschrijving
            </label>
            <textarea class="form-control border-black" name="product[description]" required placeholder="Product Naam"></textarea>
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
        </div>
        <div id="set" class="d-none price form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[price]">
                Product Prijs
            </label>
            <input class="form-control border-black" name="listing[price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
        </div>
        <div id="bidding" class="d-none price form-group mb-4">
            <div class="mb-3">
                <div class="mb-3">
                    <label class="mb-2 text-uppercase fw-bold" for="listing[bid-price]">
                        Bieden vanaf
                    </label>
                    <input class="form-control border-black" name="listing[bid-price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
                </div>
                <div class="mb-3">
                    <label class="mb-2 text-uppercase fw-bold" for="listing[bid-until]">
                        Bieden tot datum en tijd
                    </label>
                    <input class="form-control border-black" name="listing[bid-until]" type="datetime-local"/>
                </div>
            </div>
        </div>
        <div id="rental" class="d-none price form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[rent-price]">
                Huurprijs
            </label>
            <input class="form-control border-black" name="listing[rent-price]" type="text" pattern="[0-9]*"  placeholder="0,00"/>
        </div>
        <div class="form-group mb-4">
            <label class="mb-2 text-uppercase fw-bold" for="listing[amount]">
                Aantal te koop
            </label>
            <input class="form-control border-black" name="listing[amount]" type="number" min='1' required placeholder="0"/>
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
