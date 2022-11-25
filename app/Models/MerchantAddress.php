<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantAddress extends Model
{
    use HasFactory; use SoftDeletes;

    protected $table = 'merchant_addresses';

   
    protected $fillable = [
        'merchant_id',
        'address_type',
        'line_1',
        'line_2',
        'state',
        'city',
        'country',
        'zip',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at'
    ];


    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }


}
