@extends('layout', [
  'title' => 'Bazaar'
])

@section('content')
    <div class="container-fluid mt-4 p-4" style="background-color: #0049ff; ">
        <div class="row ps-4">
            <div class="col m-2" style="background-color: black; transform: skew(-3deg); box-shadow: -10px -10px 0px 5px rgba(50, 0, 255); position: relative ">
                <h2 class="text-uppercase mt-5 p-5"
                    style="font-size: 4em; color: white; transform: skew(-3deg); ">De nieuwste producten die onze adverteerders
                    aanbieden
                </h2>
            </div>
            <div class="col ms-2">
                <div class="row justify-content-center">
                    @foreach($latestAdvertisements as $latestAdvertisement)
                            <div class="col-md-6 mb-3">
                                <a href="{{Route('listings.show', $latestAdvertisement->id)}}">
                                <div class="text-center" style="transform: skew(-3deg);
                                    box-shadow: -10px -10px 0px 0px rgba(50, 0, 255);
                                    background-image: url({{$latestAdvertisement->getImageUrl()}});
                                    background-repeat: no-repeat; background-size: cover; background-position: center; min-height: 15em; position: relative">
                                    <div class="mt-2" style="color: white; ">
                                        <h3 class="text-uppercase p-3"
                                            style="position: absolute; top: 70%; background-color: #1a202c; max-width: 50%" >{{$latestAdvertisement->product->product_name}}</h3>
                                    </div>
                                </div>
                                </a>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


