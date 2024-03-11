@extends('layout', [
    'title' => 'Profiel bewerken'
])

@php
    use App\Models\Role;
@endphp

@section('content')
    <div class="col">

    </div>
    <div class="col">
        <div class="mt-1">
            <h2>Profiel {{$user->name}} {{$user->lastname}}</h2>
            @if(Auth::user()->role_id === 4)
                <a href="{{ route('admin.index') }}" style="text-decoration: none" class="float-end text-uppercase">Terug</a>
            @endif
        </div>
        <div class="mt-5">
            @if(session('success_message'))
                <span class="alert alert-success">
                    {{session('success_message')}}
                </span>
            @endif

            @if(session('error_message'))
                <span class="alert alert-danger">
                    {{session('error_message')}}
                </span>
            @endif
        </div>
        <div class="mt-5">
            @if(session('token'))
                <span class="alert alert-success">
                    {{session('token')}}
                </span>
            @endif
        </div>
        <form class="mt-5" action="{{Route('user.getKey', $user->id)}}" method="POST">
            @csrf
            <input type="submit" class="btn btn-primary" value="API Key ophalen">
        </form>
        <form action="{{route('users.update', $user->id)}}" method="POST" class="mt-3">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="name" class="mb-3 text-uppercase fw-bold">Voornaam:</label>
                <input type="text" class="form-control border-black" id="name" name="name" value="{{$user->name}}" placeholder="Voornaam">
                @error('name')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="lastname" class="mb-2 text-uppercase fw-bold">Achternaam:</label>
                <input type="text" class="form-control border-black" id="lastname" name="lastname" value="{{$user->lastname}}"  placeholder="Achternaam" >
                @error('lastname')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-4">
                <label for="street" class="mb-2 text-uppercase fw-bold">Straat:</label>
                <input type="text" class="form-control border-black" id="street" name="street" value="{{$user->street}}" placeholder="Straatnaam">
                @error('street')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-2">
                <label for="house_number" class="mb-2 text-uppercase fw-bold  mt-2">Huisnummer:</label>
                <input type="text" class="form-control border-black ms-3 me-3" style="max-width: 6vh; border-radius: 5px;text-align:center;" id="house_number" name="house_number" value="{{$user->house_number}}"  placeholder="0" >
                <label for="postal_code" class="mb-2 text-uppercase fw-bold ms-3 mt-2">Postcode:</label>
                <input type="text" class="form-control border-black ms-3 " style="max-width: 10vh; border-radius: 5px"  id="postal_code" name="postal_code" placeholder="Postcode" value="{{$user->postal_code}}" >
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
                <input type="email" class="form-control border-black w-50" id="email" name="email" value="{{$user->email}}"  placeholder="E-mail">
                @error('email')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" type="radio" name="type_user"
                       {{($user->role_id === 1)  ? "checked" : ""}} id="type_user_none_advertiser" required>
                <label class="form-check-label" for="type_user_none_advertiser">
                    Geen adverteerder
                </label>
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" type="radio" name="type_user"
                       {{($user->role_id === 2)  ? "checked" : ""}}  id="type_user_proprietary_advertiser" value="particuliere adverteerder">
                <label class="form-check-label" for="type_user_proprietary_advertiser">
                    Particuliere adverteerder
                </label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="radio" name="type_user"
                       {{($user->role_id === 3 ) ? "checked" : ""}}  id="type_user_commercial_advertiser" value="zakelijke adverteerder">
                <label class="form-check-label" for="type_user_commercial_advertiser">
                    Zakelijke adverteerder
                </label>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary text-uppercase">Bevestigen</button>
            </div>
        </form>
        <div class="mt-3">
            @if((Role::find($user->role_id))->role_name === 'commercial'
                && (Role::find(Auth::user()->role_id))->role_name === 'admin' )
            <form action="{{route('admin.upload', $user)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="mb-2" for="upload-contract">Upload de contract voor zakelijk adverteerder</label>
                    <input type="file" id="upload-contract" name="contract">
                    <button type="submit" class="btn btn-dark text-uppercase">Upload</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    <div class="col">

    </div>
@endsection

