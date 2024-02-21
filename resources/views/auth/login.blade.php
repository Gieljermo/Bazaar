@extends('layout', [
      'title' => 'Inloggen'
])

@section('content')
    <div class="col-5"></div>
    <div class="col ">
        <form action="{{ route('login') }}" method="POST" class="mt-4 align-content-center">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group mb-4">
                <label for="email" class="mb-2 text-uppercase fw-bold">E-mail:</label>
                <input type="email" class="form-control border-black" id="email" name="email"  placeholder="E-mail">
            </div>
            <div class="form-group mb-3">
                <label for="wachtwoord" class="mb-2 text-uppercase fw-bold">Wachtwoord:</label>
                <input type="password" class="form-control border-black" id="wachtwoord" name="password"  placeholder="Wachtwoord">
            </div>
            <div class=text-center>
                <button type="submit" class="btn btn-primary text-uppercase">Log in</button>
            </div>
            @if (session('message'))
                <div class="alert alert-success mt-2">
                    <li>
                        {{ session('message') }}
                    </li>
                </div>
            @endif
        </form>
    </div>
    <div class="col-5"></div>
@endsection
