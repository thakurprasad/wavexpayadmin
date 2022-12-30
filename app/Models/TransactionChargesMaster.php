<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionChargesMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'interval',
        'charges',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
}
