<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashBoardHeader extends Model
{
    protected $table = 'dashboardheader';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'created_at', 'updated_at'
    ];
}
