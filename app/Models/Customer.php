<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
class Customer extends Model
{
    use Sortable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

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
    protected $fillable = ['customer_name', 'mobile', 'mobile_2', 'address', 'locality','status', 'created_at', 'updated_at'];
    public $sortable = ['customer_name', 'mobile', 'mobile_2', 'address','locality','status','created_at', 'updated_at'];


    /*  include extra where condication in every select query for this model   */
    public function newQuery($auth = true) {
        return parent::newQuery($auth)->where([
                'transaction_mode'=> session()->get('mode') 
            ]);
    }

}
