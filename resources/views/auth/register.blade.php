@extends('layout', [
    'title' => 'registeren'
])

@section('content')
    <div class="col">

    </div>
    <div class="col">
        <form action="{{route('register')}}" method="POST" class="mt-4">
            @csrf
            <div class="form-group mb-4">
                <label for="name" class="mb-3 text-uppercase fw-bold">Voornaam:</label>
                <input type="text" class="form-control border-black" id="name" name="name" value="{{old('voornaam')}}" placeholder="Voornaam">
                @error('name')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="lastname" class="mb-2 text-uppercase fw-bold">Achternaam:</label>
                <input type="text" class="form-control border-black" id="lastname" name="lastname" value="{{old('achternaam')}}"  placeholder="Achternaam" >
                @error('lastname')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="street" class="mb-2 text-uppercase fw-bold">Straat:</label>
                <input type="text" class="form-control border-black" id="street" name="street" value="{{old('straat')}}" placeholder="Straatnaam">
                @error('street')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-4">
                <label for="house_number" class="mb-2 text-uppercase fw-bold  mt-2">Huisnummer:</label>
                <input type="text" class="form-control border-black ms-3 me-3" style="max-width: 6vh; border-radius: 5px;text-align:center;" id="house_number" name="house_number" value="{{old('huisnummer')}}"  placeholder="0" >
                <label for="postal_code" class="mb-2 text-uppercase fw-bold ms-3 mt-2">Postcode:</label>
                <input type="text" class="form-control border-black ms-3 " style="max-width: 10vh; border-radius: 5px"  id="postal_code" name="postal_code" placeholder="Postcode" value="{{old('postcode')}}" >
            </div>
            <div>
                @error('house_number')
                    <div class="alert alert-danger p-2">{{ $message }}</div>
                @enderror
                @error('postal_code')
                    <div class="alert alert-danger p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="email" class="mb-2 text-uppercase fw-bold">E-mail:</label>
                <input type="email" class="form-control border-black w-50" id="email" name="email" value="{{old('email')}}"  placeholder="E-mail">
                @error('email')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password" class="mb-2 text-uppercase fw-bold">Wachtwoord:</label>
                <input type="password" class="form-control border-black w-50" id="password" name="password"  placeholder="Wachtwoord">
                @error('password')
                    <div class="alert alert-danger mt-2 p-2">{{ $message }}</div>
                @enderror
                <label for="password_confirmation" class="mb-2 text-uppercase fw-bold mt-2">Wachtwoord bevestigen:</label>
                <input type="password" class="form-control border-black w-50" id="password_confirmation" name="password_confirmation"  placeholder="Wachtwoord">
                @error("password_confirmation")
                    <div class="alert alert-danger mt-2 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <small>
                    * Hieronder kies of je een particulier of zakelijke adverteerder bent.
                </small>
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" type="radio" name="type_user" id="type_user_none_advertiser" required checked>
                <label class="form-check-label" for="type_user_none_advertiser">
                    Geen adverteerder
                </label>
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" type="radio" name="type_user" id="type_user_proprietary_advertiser" value="particuliere adverteerder">
                <label class="form-check-label" for="type_user_proprietary_advertiser">
                    Particuliere adverteerder
                </label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="radio" name="type_user" id="type_user_commercial_advertiser" value="zakelijke adverteerder">
                <label class="form-check-label" for="type_user_commercial_advertiser">
                    Zakelijke adverteerder
                </label>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Bevestigen</button>
            </div>
        </form>
    </div>
    <div class="col">

    </div>
@endsection

