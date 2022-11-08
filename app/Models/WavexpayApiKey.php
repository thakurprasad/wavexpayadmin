<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WavexpayApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'test_api_key', 
        'test_api_secret', 
        'live_api_key', 
        'live_api_secret',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function merchants()
    { 
         return $this->hasMany(Merchant::class);
    }  


}
