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
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
         $this->middleware('permission:merchant-list');
         $this->middleware('permission:merchant-create', ['only' => ['create','store']]);
         $this->middleware('permission:merchant-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:merchant-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->payment->all();

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('transactions.payments',compact('data'));
    }

    public function refunds(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->refund->all();

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('transactions.refunds',compact('data'));
    }

    public function batchrefunds(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->refund->all();

        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('transactions.refunds',compact('data'));
    }

    public function orders(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->order->all();
        //dd($data);
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('transactions.orders',compact('data'));
    }

}
