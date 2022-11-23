<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantKey;

class SetGatwayController extends Controller
{
    public function setGatwayMode($mode){
        try{
            session()->put('mode', $mode); 
            
            /*$merchent_id = session()->get('merchant');            
            $row = MerchantKey::where('merchnat_id', $merchent_id)->first();
            if($mode == 'test'){
                session()->put('merchant_key', $row->test_api_key);
                session()->put('merchant_secret',$row->test_api_secret);
            }else if($mode ='live'){       
                 session()->put('merchant_key', $row->live_api_key);
                session()->put('merchant_secret',$row->live_api_secret);
            }else{
                // nothing..
            } */

            return redirect()->back();
         } catch (\Exception $e) {
            return redirect()->back()->withErrors("Error: ".$e->getMessage());
        }
    }
}
