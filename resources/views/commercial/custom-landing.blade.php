@extends('layout', [
    'title' => 'Bazaar'
])

@section('content')
    <div class="d-flex w-75 flex-column">
        @foreach ($components as $component)
            <div class="component-header">
                <h1>{{$component->header}}</h1>
                <p>{{$component->text}}</p>
                @if(!$component->listings->isEmpty())
                <div class="component-product-container d-flex flex-row">
                    @foreach ($component->listings as $listing)
                        @include('components.listing-card', ['listing' => $listing, 'favorites' => $favorites])
                    @endforeach
                </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection

