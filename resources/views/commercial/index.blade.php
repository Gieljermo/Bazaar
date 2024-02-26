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
                    <h3>Jouw contract moet nog gecontroleerd en geupload worden door de administratie</h3>
                </div>
            @else
                <h3 class="text-uppercase">Hieronder is jouw contract</h3>
                <span></span>
                <embed src="data:application/pdf;base64,{{ base64_encode($contract->file) }}" type="application/pdf"
                       width="100%" height="600px"/>
                <div class="mt-2">
                    <span class="mt-2">*Ga je akkoord met de voorwaarden, druk dan op deze knop </span>
                    <a href="{{route('commercial.contract', $contract)}}" class="btn btn-success text-uppercase mt-2" type="submit">Contract accepteren</a>
                </div>
            @endif
        @endunless

        @unless($contract->accepted == 0)
        @endunless
    </div>
    <div class="col">

    </div>
@endsection
