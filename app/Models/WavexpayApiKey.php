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

    public static function get_api_key_categories_arr(){
        $rows = WavexpayApiKey::select(
            'wavexpay_api_keys.id', 
            'wavexpay_api_keys.test_api_key', 
            'wavexpay_api_keys.live_api_key', 
            'wavexpay_api_keys.key_description',
            'api_key_categories.category_name'
        )
        ->join('api_key_categories', 'api_key_categories.id', '=', 'wavexpay_api_keys.category_id')->get();
        $DATA[''] = '-- Select --';
        foreach ($rows as $key => $row) {
            $DATA[$row->id] = ucfirst($row->category_name) . ' - '.$row->key_description;
        }
        return $DATA;
    }

}
