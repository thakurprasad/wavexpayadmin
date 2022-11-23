<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DateRangePicker extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $daterangepicker_id = 'daterangepicker';
    public $label = '';
    public function __construct($id = 'daterangepicker', $label = '')
    {
        $this->daterangepicker_id = $id;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.date-range-picker');
    }
}
