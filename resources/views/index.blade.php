@extends('layout', [
  'title' => 'Bazaar'
])

@section('content')
    <div class="container-fluid mt-4 p-4" style="background-color: #0049ff; ">
        <div class="row ps-4">
            <div class="col m-2 ad-card">
                <h2 class="text-uppercase mt-5 p-5 ad-text">
                    De nieuwste producten die onze adverteerders aanbieden
                </h2>
            </div>
            <div class="col ms-2">
                <div class="row justify-content-center">
                    @foreach($latestAdvertisements as $latestAdvertisement)
                            <div class="col-md-6 mb-3">
                                <a href="{{Route('listings.show', $latestAdvertisement->id)}}">
                                <div class="text-center image-card" style="background-image: url({{$latestAdvertisement->getImageUrl()}});">
                                    <div class="mt-2" style="color: white; ">
                                        <h3 class="text-uppercase p-3 pr-text">
                                            {{$latestAdvertisement->product->product_name}}
                                        </h3>
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


