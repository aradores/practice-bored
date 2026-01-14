<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputError extends Component
{
    public $for;

    public function __construct($for = null)
    {
        $this->for = $for;
    }

    public function render()
    {
        return view('components.input-error');
    }
}
