<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\State;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_name', 'country_code2', 'country_code3', 'status', 'position_order', 'created_at', 'updated_at'];

    // Fetch employee by department id
    public static function getStates($country_id=0)
    {
        $value=State::select('id','state_name')->where('country_id', $country_id)->orderBy('state_name','ASC')->get();
        return $value;
    }
}
