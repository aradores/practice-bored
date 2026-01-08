<?php

namespace App\View\Components\DatePicker;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateRangePicker extends Component
{
    public $date_picker_id;
    public $from;
    public $to;
    public $maxDateToday = true;
    public $placeholder;

    /**
     * Create a new component instance.
     */
    public function __construct($from = null, $to = null, $id, $maxDateToday = true, $placeholder = null)
    {
        $this->date_picker_id = $id;
        $this->from = $from;
        $this->to = $to;
        $this->maxDateToday = $maxDateToday;
        $this->placeholder = $placeholder ?? 'Select date...';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.date-picker.date-range-picker');
    }
}