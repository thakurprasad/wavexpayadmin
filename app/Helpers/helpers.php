<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use DB;

class Helpers
{
    public static function get_all_merchants(){
        $get_all_merchants = DB::table('merchants')->get();
        return $get_all_merchants;
    } 
}


