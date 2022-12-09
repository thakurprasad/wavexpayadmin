<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $form_id = "search_form";
    public $method = "POST";
    public $action = "";
    public $status = '';
    public $advance_filters = 'show';
    public function __construct($form_id="search_form", $method = 'GET', $action = '', $status = '', $advancefilters)
    {
        $this->form_id = $form_id;
        $this->method  = $method;
        $this->status  = $status;
        $this->advance_filters  = $advancefilters;
        $this->action  = url($action);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if($this->advance_filters == 'show'){
            return view('components.filter-component');
        }else{
            return view('components.filter-component-2');    
        }
        
    }
}
