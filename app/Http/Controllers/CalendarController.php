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
    public function index(Request $request){
        
        $month = $request->input('current-month', Carbon::now()->month);
        $year = $request->input('current-year', Carbon::now()->year);
        if ($request->has('month-up')) {
            $date = Carbon::create($year, $month, 1)->addMonth();
        } elseif ($request->has('month-down')) {
            $date = Carbon::create($year, $month, 1)->subMonth();
        } else {
            $date = Carbon::now()->startOfMonth();
        }

        $daysInMonth = Carbon::createFromDate(null, $date->month, 1)->daysInMonth;

        $calendarData = [];


        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($date->year, $date->month, $day);


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
            'emptyDays' => $date->startOfMonth()->dayOfWeekIso - 1,
            'month' => $date->month,
            'monthName' => Carbon::createFromFormat('m', $date->month)->format('F'),
            'year' => $date->year,
        ]);
    }
}
