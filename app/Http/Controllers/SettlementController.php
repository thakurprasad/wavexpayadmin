<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Merchant;
use App\Models\MerchantKey;
use App\Models\MerchantUser;
use Razorpay\Api\Api;
use DateTime;
class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settlements(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->settlement->all();

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('settlement.index',compact('data'));
    }

}
