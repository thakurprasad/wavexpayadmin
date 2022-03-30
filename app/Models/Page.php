<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'contents';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_title', 'url_aliase', 'banner_image', 'banner_text', 'meta_title', 'meta_keywords', 'meta_description', 'content', 'created_at', 'updated_at'
    ];
}
