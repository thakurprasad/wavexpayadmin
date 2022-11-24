<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    

    /*  include extra where condication in every select query for this model   */
    public function newQuery($auth = true) {
        return parent::newQuery($auth)->where([
                'transaction_mode'=> session()->get('mode') 
            ]);
    }

}
