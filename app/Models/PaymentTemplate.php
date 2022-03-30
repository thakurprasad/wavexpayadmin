<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTemplate extends Model
{
    protected $table = 'payment_templates';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'payment_type',  'subtitle', 'status', 'bg_image', 'description', 'created_at', 'updated_at'
    ];
}
