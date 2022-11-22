<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\WavexpayApiKey;

class MerchantKeyComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $all_api_keys =  WavexpayApiKey::all();
        return view('components.merchant-key-component',compact('all_api_keys'));
    }
}
