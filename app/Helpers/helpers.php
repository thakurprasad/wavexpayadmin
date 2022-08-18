<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use DB;

class Helpers
{
    public static function get_all_merchants(){
        $get_all_merchants = DB::table('merchants')->orderBy('created_at','DESC')->get();
        return $get_all_merchants;
    } 
}


