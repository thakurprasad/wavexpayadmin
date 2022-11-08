<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKeyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_description',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
}
