<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InvoiceItem extends Model
{
    use HasFactory;

    public $timestamps = false; 

    protected $fillable = [
            'item_id',
            'invoice_id',
            'name',
            'description',
            'amount',
            'quantity'
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
