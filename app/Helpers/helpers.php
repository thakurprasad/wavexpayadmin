<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use DB;
use App\Models\ApiKeyCategory;

class Helpers
{
    public static function get_all_merchants(){
        $get_all_merchants = DB::table('merchants')->orderBy('created_at','DESC')->get();
        return $get_all_merchants;
    }

    public static function get_api_key_categories(){
        $rows = ApiKeyCategory::select('id', 'category_name')->get();
        $DATA = array();
        foreach ($rows as $key => $row) {
            #echo $row->category_name;
            $DATA[$row->id] = $row->category_name;
        }                
        return $DATA;
    }
}


