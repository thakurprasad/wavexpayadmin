<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $table = 'merchants';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_name', 'access_salt',  'contact_name', 'contact_phone', 'status', 'is_partner', 'reward_value', 'merchant_payment_method', 'created_at', 'updated_at', 'wavexpay_api_key_id'
    ];
}
