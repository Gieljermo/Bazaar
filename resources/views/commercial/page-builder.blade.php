@extends('layout', [
    'title' => 'Profiel bewerken'
])

@section('content')
    <div class="col">
        @include('partials.sidebar')
    </div>
    <div class="col">
        <form action="{{Route('commercial.page-builder.store', Auth::user()->id)}}" method="POST">
            @csrf
            @if(session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif
            @error('component')
                <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
            @enderror
            <div id="componentContainer">
                @php
                    $index = 0
                @endphp
                @foreach ($components as $component)
                <div class="component-form-group form-group mb-4 card">
                    <input type="hidden" name="component[{{$index}}][id]" value="{{$component->id}}"/>
                    <i class="bi bi-trash" data-component-id="{{ $component->id }}"></i>
                    <label class="mb-2">
                        Titel
                    </label>
                    <input class="form-control" name="component[{{$index}}][header]" type="text" value="{{$component->header}}" placeholder="component titel"/>
                    <label class="mb-2">
                        Component Tekst
                    </label>
                    <input class="form-control" name="component[{{$index}}][text]" type="text" value="{{$component->text}}" placeholder="component tekst"/>
                    <label class="mb-2">
                        Producten toevoegen
                    </label>
                    <div class="listing-select" data-index="{{$index}}">
                        <div tabindex="0" class="form-control listing-id-container">
                            @foreach ($component->listings as $listing)
                                <div class="selected-listing-wrapper">
                                    <input type="hidden" name="component[{{$index}}][product][]" value="{{$listing->id}}"/>
                                    <p data-image="{{$listing->getImageUrl()}}" data-price="{{$listing->price}}" class="selected-listing">{{$listing->product->product_name}}<i class="bi bi-x"></i></p>
                                </div>
                            @endforeach
                            <input type="text" class="hidden-search"/>
                        </div>
                        <div class="listing-list">
                        </div>
                    </div>
                </div>
                @php
                    $index++
                @endphp
                @endforeach
            </div>
            <input class="btn btn-primary" type="submit" value="verzenden"/>
        </form>
        @foreach ($components as $component)
            <form class="invisible delete-form" action="{{Route('commercial.page-builder.delete', $component->id)}}" method="POST" data-component-id="{{ $component->id }}">
                @csrf
                @method("DELETE")
            </form>
        @endforeach
    </div>
    <div class="col">
        <button id="addComponent" class="btn btn-primary">Extra Component toevoegen</button>
    </div>

    @vite(['resources/js/page-builder.js'])

@endsection

