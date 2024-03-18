<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CalendarModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $rentData = [])
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar-modal');
    }
}
