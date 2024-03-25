@extends('layout', [
    'title' => 'Kalender',
    'heading' => 'Kalender'
])

@section('content')
    <div class="month_selector w-75 d-flex justify-content-center">
        <form action="{{Route('customer.calendar')}}" class="month-selector-form d-flex align-items-center" method="GET">
            @csrf
            <input type="hidden"  name="current-month" value="{{$month}}"/>
            <input type="hidden"  name="current-year" value="{{$year}}"/>
            <button class="btn btn-secondary" type="submit" name="month-down" value="-"><</button>
            <h2 style="margin: 0">{{$monthName}} {{$year}}</h2>
            <button class="btn btn-secondary" type="submit" name="month-up" value="+">></button>
        </form>
    </div>
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

                {{-- GEHUURDE PRODUCTEN --}}
                @if(count($day['rentalStart']) == 1)
                    @foreach ($day['rentalStart'] as $rentStart)
                        <div class="calendar-item calendar-item-start">
                            <p class="p-1">{{$rentStart->listing->user->name}} {{$rentStart->listing->user->lastname}} - {{$rentStart->listing->product->product_name}}</p>
                        </div>
                    @endforeach
                @elseif(count($day['rentalStart']) > 1)
                    <div class="calendar-item calendar-item-start">
                        <p class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#hiredModal">Meerdere producten bekijken...</p>
                    </div>
                    <x-calendar-modal id="hiredModal" title="Ophalen gehuurde producten" type='hired'  :rentData="$day['rentalStart']"></x-calendar-modal>
                @endif

                @if(count($day['rentalEnd']) == 1)
                    @foreach ($day['rentalEnd'] as $rentEnd)
                        <div class="calendar-item calendar-item-end">
                            <p class="p-1">{{$rentEnd->listing->user->name}} {{$rentEnd->listing->user->lastname}} - {{$rentEnd->listing->product->product_name}}</p>
                        </div>
                    @endforeach
                @elseif(count($day['rentalEnd']) > 1)
                    <div class="calendar-item calendar-item-end">
                        <p class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#hiredModal">Meerdere producten bekijken...</p>
                    </div>
                    <x-calendar-modal id="hiredModal" title="Ophalen gehuurde producten" type='hired' :rentData="$day['rentalEnd']"></x-calendar-modal>
                @endif
                
                {{-- VERHUURDE PRODCUTEN --}}
                @if(count($day['listingStart']) == 1)
                    @foreach ($day['listingStart'] as $ownRentalStart)

                        <div class="calendar-item calendar-item-own-start">
                            <p class="p-1">{{$ownRentalStart->user->name}} {{$ownRentalStart->user->lastname}} - {{$ownRentalStart->listing->product->product_name}}</p>
                        </div>
                    @endforeach
                @elseif(count($day['listingStart']) > 1)
                    <div class="calendar-item calendar-item-own-start">
                        <p class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#rentedModal">Meerdere producten bekijken...</p>
                    </div>
                    <x-calendar-modal id="rentedModal" title="Ophalen gehuurde producten" type='rented'  :rentData="$day['listingStart']"></x-calendar-modal>
                @endif

                @if(count($day['listingEnd']) == 1)
                    @foreach ($day['listingEnd'] as $ownRentalEnd)
                        <div class="calendar-item calendar-item-own-end">
                            <p class="p-1">{{$ownRentalEnd->user->name}} {{$ownRentalEnd->user->lastname}} - {{$ownRentalEnd->listing->product->product_name}}</p>
                        </div>
                    @endforeach
                @elseif(count($day['listingEnd']) > 1)
                    <div class="calendar-item calendar-item-own-end">
                        <p class="p-1" href="#" data-bs-toggle="modal" data-bs-target="#rentedModal">Meerdere producten bekijken...</p>
                    </div>
                    <x-calendar-modal id="rentedModal" title="Ophalen gehuurde producten" type='rented'   :rentData="$day['listingEnd']"></x-calendar-modal>
                @endif
            </div>
        @endforeach
    </div>
    <div class="w-75 calendar-legend d-flex flex-column">
        <div class="legend-item d-flex flex-row">
            <div class="legend-box calendar-item-start"> </div>
            <p>Gehuurd product ontvangen</p>
        </div>
        <div class="legend-item d-flex flex-row">
            <div class="legend-box calendar-item-end"> </div>
            <p>Gehuurd product terugbrengen</p>
        </div>
        <div class="legend-item d-flex flex-row">
            <div class="legend-box calendar-item-own-start"> </div>
            <p>Eigen verhuurd product opsturen</p>
        </div>
        <div class="legend-item d-flex flex-row">
            <div class="legend-box calendar-item-own-end"> </div>
            <p>Eigen verhuurd product ontvangen</p>
        </div>
    </div>
@endsection
