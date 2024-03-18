<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use App\Models\Rental;
use App\Models\Listing;

class CalendarController extends Controller
{
    public function index(){
        

        $daysInMonth = Carbon::now()->daysInMonth;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $calendarData = [];


        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);


            $rentalStart = Rental::where('user_id', Auth::user()->id)
                ->whereDate('from', $date->toDateString())->get();

            $rentalEnd = Rental::where('user_id', Auth::user()->id)
                ->whereDate('until', $date->toDateString())->get();

            $listingStart = Listing::where('user_id', Auth::user()->id)
                ->with(['rentals' => function($query) use ($date) {
                    $query->whereDate('from', $date);
                }])
                ->get()
                ->pluck('rentals')
                ->collapse();
                

            $listingEnd = Listing::where('user_id', Auth::user()->id)
                ->with(['rentals' => function($query) use ($date) {
                    $query->whereDate('until', $date);
                }])
                ->get()
                ->pluck('rentals')
                ->collapse();


            $calendarData[] = [
                'dayNumber' => $day,
                'dayName' => $date->englishDayOfWeek,
                'rentalStart' => $rentalStart,
                'rentalEnd' => $rentalEnd,
                'listingStart' => $listingStart,
                'listingEnd' => $listingEnd,
            ];

        }

        return view('customer.rentals', [
            'calendarData' => $calendarData,
            'emptyDays' => Carbon::Now()->startOfMonth()->dayOfWeekIso - 1,
        ]);
    }
}
