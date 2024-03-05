<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @stack('scripts')
    <link rel="stylesheet" href="{{asset('~/css/stylesheet')}}">
    <title>{{$title}}</title>
</head>

@php
    use App\Models\Role;
@endphp
<body class="m-1">
    <div class="container m-0 mw-100">
        <div class="row pb-2 border-bottom border-primary">
            <div class="col mt-1">
                <div class="nav">
                    <div class="nav-item me-2">
                        <a class="nav-link text-uppercase" href="{{Route('home')}}">home</a>
                    </div>
                    <div class="ms-auto d-flex">
                        <div class="nav-item me-2 ">
                            <a class="btn btn-primary" href="{{Route('listings.create')}}">Plaats Advertentie</a>
                        </div>
                    </div>
                    @guest()
                        <div class="nav-item me-2 ">
                            <a class="nav-link text-uppercase" href="/register">registeren</a>
                        </div>
                        <div class="nav-item me-2 ">
                            <a class="nav-link text-uppercase" href="/login">login</a>
                        </div>
                    @endguest

                    @auth()
                        <div class="nav-item me-2 ">
                            <form id="logout_page" action="{{route('logout')}}" method="post">
                                @csrf
                            </form>
                            <a class="nav-link text-uppercase" href="javascript:document.getElementById('logout_page').submit()">
                                uitloggen
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="col">
                @auth
                    <nav class="d-flex justify-content-end">
                        <div class="nav-item ms-3 mt-1 dropdown">
                                <button class="btn dropdown-toggle" style="font-size: 20px" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                @if(Role::find(Auth::user()->role_id)->role_name === "commercial")
                                    <li><a href="{{route('commercial.contract')}}" class="text-uppercase dropdown-item" style="text-decoration: none">Contract</a></li>
                                @endif
                                @if(Role::find(Auth::user()->role_id)->role_name === "customer")
                                        <li><a href="{{route('customer.favorite')}}"
                                               class="text-uppercase dropdown-item" style="text-decoration: none">Favorieten</a>
                                        </li>
                                        <li><a href="{{route('customer.favorite')}}"
                                               class="text-uppercase dropdown-item" style="text-decoration: none">Bestellingen</a>
                                        </li>
                                @endif
                                <li><a class="text-uppercase dropdown-item"  href="{{ route('users.edit', Auth::user()->id) }}">Profiel</a></li>
                            </ul>
                        </div>
                    </nav>
                @endauth
            </div>
        </div>
        <div class="row ">
            <h1 class="text-center text-uppercase mt-4">{{$heading}}</h1>
            @yield('content')
        </div>
    </div>
</body>
</html>

