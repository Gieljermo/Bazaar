@extends('layout', [
    'title' => 'Advertenties',
    'heading' => 'Advertenties'
])

@section('content')
    <div class="calendar w-75 d-flex">
        <div class="calendar-day-names d-flex">
            <p>maandag</p>
            <p>dinsdag</p>
            <p>woendag</p>
            <p>donderdag</p>
            <p>vrijdag</p>
            <p>zaterdag</p>
            <p>zondag</p>
        </div>
        @for ($i = 0; $i < $emptyDays; $i++)
            <div class="calendar-day empty-day">
            </div>
        @endfor
        @foreach ($calendarData as $day)
            <div class="calendar-day">
                <p>{{$day['dayNumber']}}</p>
            </div>
        @endforeach
    </div>
@endsection
