<?php

namespace App\View\Components\DatePicker;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateTimePicker extends Component
{
    public $date_picker_id;
    public $value;
    public $placeholder;
    public bool $minDateEnabled;

    public function __construct($id, $value = null, $placeholder = null, $minDateEnabled = false)
    {
        $this->date_picker_id = $id;
        $this->value = $value; // "YYYY-MM-DD HH:mm" or null
        $this->placeholder = $placeholder ?? 'MM/DD/YYYY HH:mm';
        $this->minDateEnabled = $minDateEnabled;
    }

    public function render(): View|Closure|string
    {
        return view('components.date-picker.date-time-picker');
    }
}
