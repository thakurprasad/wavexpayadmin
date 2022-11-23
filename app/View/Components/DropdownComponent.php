<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DropdownComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $status = '';
    public function __construct($status = '')
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $options = [];
        if($this->status == 'payments'){
            $options = ['authorized' => 'Authorized', 'captured' => 'Captured', 
                        'refunded' => 'Refunded', 'failed' => 'Failed'];
        }
        if($this->status == 'refunds'){
            $options = ['created'=>'Created', 'accepted'=>'Accepted', 'paid'=>'Paid'];
        }
        if($this->status == 'orders'){
            $options = ['created'=>'Created', 'attempted'=>'Attempted', 'paid'=>'Paid'];
        }
        if($this->status == 'disputes'){
            $options = ['open'=>'Open', 'under_review'=>'Under Review', 'lost'=>'Lost','won'=>'Won', 'closed'=>'Closed'];
        }
        if($this->status == 'settlements'){
            $options = ['created'=>'Created', 'processed'=>'Processed', 'failed'=>'Failed'];
        }
        if($this->status == 'paymentlinks'){
            $options = ['created'=>'Created', 'partially_paid'=>'Partially Paid', 'expired'=>'Expired','cancelled'=>'Cancelled','paid'=>'Paid'];
        }
        if($this->status == 'paymentpages'){
            $options = ['Active'=>'Active', 'Inactive'=>'Inactive'];
        }
        if($this->status == 'invoices'){
            $options = ['draft'=>'Draft', 'issued'=>'Issued','partially_paid'=>'Partially Paid','paid'=>'Paid','cancelled'=>'Cancelled','expired'=>'Expired','deleted'=>'Deleted'];
        }
        return view('components.dropdown-component', ['options'=> $options]);
    }
}
