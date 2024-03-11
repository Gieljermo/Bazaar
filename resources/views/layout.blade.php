<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
            <div class="col">
                <div class="nav">
                    <div class="nav-item me-2">
                        <a class="nav-link text-uppercase" href="{{Route('home')}}">home</a>
                    </div>
                    <div class="nav-item me-2">
                        <a class="nav-link text-uppercase" href="{{Route('listings.index')}}">Advertenties</a>
                    </div>
                    <div class="ms-auto d-flex">
                        <div class="nav-item me-2">
                            <a class="btn btn-primary" href="{{Route('listings.create')}}">Plaats Advertentie</a>
                        </div>
                        @guest()
                            <div class="nav-item me-2">
                                <a class="nav-link text-uppercase" href="/register">register</a>
                            </div>
                            <div class="nav-item me-2">
                                <a class="nav-link text-uppercase" href="/login">login</a>
                            </div>
                        @endguest

                        @auth()
                            
                            @if(Role::find(Auth::user()->role_id)->role_name === "commercial")
                                <div class="nav-item me-2">
                                    <div>
                                        <a href="{{route('commercial.contract')}}" class="text-uppercase nav-link" style="text-decoration: none">Contract</a>
                                    </div>
                                </div>
                            @endif
                            <div class="nav-item me-2">
                                <div>
                                    <a class="nav-link text-uppercase" href="{{ route('users.edit', Auth::user()->id) }}">
                                        {{ Auth::user()->name }}
                                    </a>
                                </div>
                            </div>
                            <div class="nav-item me-2">
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
            </div>
        </div>
        <div class="row justify-content-center">
            @if(session('listing_error'))
                <div class="alert alert-danger">
                    {{ session('listing_error') }}
                </div>
            @endif
            <h1 class="text-center text-uppercase mt-4">{{$title}}</h1>
            @yield('content')
        </div>
    </div>
</body>
</html>

