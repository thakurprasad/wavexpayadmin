<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantKey extends Model
{
    protected $table = 'merchant_keys';
    protected $primaryKey = 'id'; 

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'merchnat_id', 'api_title', 'test_api_key', 'test_api_secret', 'live_api_key', 'live_api_secret', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
