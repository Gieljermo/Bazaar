<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 

class CalendarController extends Controller
{
    public function index(){
        

        $daysInMonth = Carbon::now()->daysInMonth;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $calendarData = [];


        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $calendarData[] = [
                'dayNumber' => $day,
                'dayName' => $date->englishDayOfWeek
            ];
        }

        return view('customer.rentals', [
            'calendarData' => $calendarData,
            'emptyDays' => Carbon::Now()->startOfMonth()->dayOfWeekIso - 1,
        ]);
    }
}
