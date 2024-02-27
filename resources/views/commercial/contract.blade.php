@extends('layout', [
    'title' => 'Bazaar commercial'
 ])

@section('content')
    <div class="col">

    </div>
    <div class="col mt-2 text-center">
        <div class="mt-5">
            @if(session('success_message'))
                <span class="alert alert-success">
                    {{session('success_message')}}
                </span>
            @endif

            @if(session('error_message'))
                <span class="alert alert-danger">
                    {{session('error_message')}}
                </span>
            @endif
        </div>
        @unless($contract->accepted == 1)
            @if($contract->file === null)
                <div class="text-center">
                    <h3>Jouw contract moet nog gecontroleerd worden en geupload worden door de administratie</h3>
                </div>
            @else
                <h3 class="text-uppercase">Hieronder kan jouw contract downloaden</h3>
                <span>
                    <a href="{{route('commercial.download.contract', $contract->id)}}">download contract van {{Auth::user()->name." ". Auth::user()->lastname}}</a>
                </span>
                <div class="mt-2">
                    <span class="mt-2">*druk op deze knop om het accepteren, na het bekijken van het contract </span>
                    <a href="{{route('commercial.accept.contract', $contract)}}" class="btn btn-success text-uppercase mt-2" type="submit">Contract accepteren</a>
                </div>
            @endif
        @endunless

        @unless($contract->accepted == 0)
            <div class="text-center">
                <h3>Je hebt jouw contract geaccepteerd</h3>
            </div>
        @endunless
    </div>
    <div class="col">

    </div>
@endsection
