@extends('layout', [
    'title' => 'Profiel bewerken'
])

@section('content')
    <div class="col">
        @include('partials.sidebar')
    </div>
    <div class="col">
        <div class="mt-5">
            @if(session('message'))
                <span class="alert alert-success">
                    {{session('message')}}
                </span>
            @endif
        </div>
        <form action="{{Route('commercial.page-settings.store', Auth::user()->id)}}" method="POST" class="mt-3">
            @csrf
            <div class="form-group mb-4">
                <label for="home_url" class="mb-3 text-uppercase fw-bold">Landingpage Url</label>
                <input type="text" class="form-control border-black" id="home_url" name="home_url" value="{{isset($settings->url) ? $settings->url : ''}}">
                @error('home_url')
                    <div class="alert alert-danger mt-1 p-2">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <button dusk='submit_settings' type="submit" class="btn btn-primary text-uppercase">Opslaan</button>
            </div>
        </form>
    </div>
    <div class="col">

    </div>
@endsection

