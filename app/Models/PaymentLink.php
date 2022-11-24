<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    protected $table = 'payment_link';
    protected $primaryKey = 'id';


    /*  include extra where condication in every select query for this model   */
    public function newQuery($auth = true) {
        return parent::newQuery($auth)->where([
                'transaction_mode'=> session()->get('mode') 
            ]);
    }
    
}
