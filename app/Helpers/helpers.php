<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;
use DB;
use App\Models\ApiKeyCategory;
use App\Models\WavexpayApiKey;
use App\Models\MerchantKey;
use App\Models\MerchantAddress;

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


     /**
     * Switch payment getway
     * $get_key = api_key|api_secret
     * 
     * $razorpay_api_key = 'rzp_test_YRAqXZOYgy9uyf'; 
     $razorpay_api_secret = 'uSaaMQw3jHK0MPtOnXCSSg51';

     * */
    public static function weveXpay($get_key){

        $api_key = session('merchant_key');
        $api_secret = session('merchant_secret');

        $merchant = MerchantKey::select('merchants.wavexpay_api_key_id')
        ->join('merchants', 'merchants.id', '=', 'merchant_keys.merchnat_id')
        ->where('merchants.id', session('merchant'))
        /*->where([
                'merchant_keys.api_key'=> $api_key,
                'merchant_keys.api_secret' => $api_secret
            ]) */
        ->first();
        

        if($merchant){
            $wavexpay_api_key_id = $merchant->wavexpay_api_key_id;
            $api_mode = session('mode'); # live | test
            
            $row = WavexpayApiKey::find($wavexpay_api_key_id);

            if(!empty($row)){
                $API_KEY = '';
                $API_SECRET = '';
                if($api_mode == 'test'){
                    
                    $API_KEY = $row->test_api_key;
                    $API_SECRET = $row->test_api_secret;

                }else if($api_mode == 'live'){                
                    
                    $API_KEY = $row->live_api_key;
                    $API_SECRET = $row->live_api_secret;

                }else{

                    die('Invalid api mode only can use test or live');
                }

                if($get_key == 'api_key'){
                    return $API_KEY;

                }else if($get_key == 'api_secret'){
                    return $API_SECRET;
                }else{
                    die('Error: invalid key type $get_key accept only - api_key|api_secret ');; 
                }
            }else{
                die('Invalid API mode or getway');
            }

        }else{
            die("Invalid api key or api secret");
        }
    } // end function of wavexpay

    /**
     * return Helper::api_key();
        return Helper::api_secret();
     * */
    public static function api_key(){
        return Helper::weveXpay('api_key');
    }
    public static function api_secret(){
        return Helper::weveXpay('api_secret');
    }


    public static function badge($string){
        $class = 'dark';
        if(in_array($string, ['authorized', 'wait', 'coming soon', 'created','partially_paid','issued'])){
             $class = 'warning';
        }
        if(in_array($string, ['draft'])){
            $class = 'info';
        }
        if(in_array($string, ['test', 'failed', 'error', 'pending','expired','cancelled','deleted'])){
             $class = 'danger';
        }
        if(in_array($string, ['live', 'captured', 'success', 'completed', 'paid','processed'])){
            $class = 'success';
        }

          return "<span class='badge badge-".$class."'>$string</span>";
    }

    public static function get_merchant_address($id){
        $address = DB::table('merchant_addresses')->where('merchant_id',$id)->get();
        return $address;
    }

    public static function get_payment_data($id,$status){
        $get_data = DB::table('payments')->where('merchant_id',$id)->where('status',$status)->get();
        $amount = 0;
        if(isset($get_data) && count($get_data)>0){
            foreach($get_data as $data){
                $amount+=$data->amount;
            }
        }
        return $amount;
    }


}


