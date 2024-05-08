@extends('layout', [
    'title' => 'Bazaar'
])

@section('content')
    <div class="d-flex w-75 flex-column">
        @foreach ($components as $component)
            <div class="component-header">
                <h1>{{$component->header}}</h1>
                <p>{{$component->text}}</p>
            </div>
        @endforeach
    </div>
@endsection

