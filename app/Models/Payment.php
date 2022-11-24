<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function payment_details()
    {
        return $this->hasOne(PaymentLink::class, 'payment_id', 'payment_id');
    }


/*  include extra where condication in every select query for this model   */
    public function newQuery($auth = true) {
        return parent::newQuery($auth)->where([
                'transaction_mode'=> session()->get('mode') 
            ]);
    }


}
