<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title></title>
</head>
<body class="m-1">
    <div class="container m-0 mw-100">
        <div class="row pb-2 border-bottom border-primary">
            <div class="col">
                <div class="nav">
                    <div class="nav-item me-2">
                        <a class="nav-link text-uppercase" href="{{Route('home')}}">home</a>
                    </div>
                    <div class="ms-auto d-flex">
                        <div class="nav-item me-2">
                            <a class="btn btn-primary" href="{{Route('listings.create')}}">Plaats Advertentie</a>
                        </div>
                        <div class="nav-item me-2">
                            <a class="nav-link text-uppercase" href="">register</a>
                        </div>
                        <div class="nav-item me-2">
                            <a class="nav-link text-uppercase" href="">login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

