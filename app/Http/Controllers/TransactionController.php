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

        $data['items'] = []; 
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
        $data['items'] = [];
        $pageConfigs = ['pageHeader' => true];
        return view('transactions.orders',compact('data'));
    }

    public function disputes(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/disputes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, 'rzp_test_YRAqXZOYgy9uyf' . ':' . 'uSaaMQw3jHK0MPtOnXCSSg51');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $all_disputes = json_decode($result, TRUE);
        curl_close($ch);
        return view('transactions.disputes',compact('all_disputes'));
    }

    function getpaymentdata(Request $request){
        $merchant_id = $request->merchant_id;
        $get_merchant_key_details = MerchantKey::where('id',$merchant_id)->first();
        $api_key = $get_merchant_key_details->api_key;
        $api_secret = $get_merchant_key_details->api_secret;
        $api = $api = new Api($api_key, $api_secret);
        $html = '';
        $options = array('count'=>10,'skip'=>0);
        $data = $api->payment->all($options);
        if(!empty($data['items'])){
            foreach($data['items'] as $key => $value){
                $html.='<tr>
                    <td>'.$value->id.'</td>
                    <td>'.$value->order_id.'</td>
                    <td>'.$value->amount.'</td>
                    <td>'.$value->email.'</td>
                    <td>'.$value->contact.'</td>
                    <td class="text-center" data-sort="'.date('d-m-Y',strtotime($value->created_at)).'">'.date('d-m-Y',strtotime($value->created_at)).'</td>
                    <td>'.$value->status.'</td>
                    <td class="text-center"><a class="btn btn-primary btn-sm" href="#"  title="Edit"><i class="fas fa-edit"></i></a></td>
                </tr>';
            }
        }
        return response()->json(array('html'=>$html));
    }


    public function searchpayment(Request $request){
        //search parameter
        $payment_id = $request->payment_id;
        $email = $request->email;
        $status = $request->status;
        $notes = $request->notes;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $start_date = DateTime::createFromFormat('d/m/Y', $start_date);
        if ($start_date === false) {
            $s_date='';
        } else {
            $s_date = $start_date->getTimestamp();
        }

        $end_date = DateTime::createFromFormat('d/m/Y', $end_date);
        if ($end_date === false) {
            $e_date='';
        } else {
            $e_date = $end_date->getTimestamp();
        }

        $hidden_merchant_id = $request->hidden_merchant_id;
        $get_merchant_key_details = MerchantKey::where('id',$hidden_merchant_id)->first();
        //get all payments data
        //$api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $api_key = $get_merchant_key_details->api_key;
        $api_secret = $get_merchant_key_details->api_secret;
        $api = $api = new Api($api_key, $api_secret);
        
        $data = $api->payment->all();
        //print_r($data['items']);exit;
        $html = '';

        if(!empty($data['items'])){
            foreach($data['items'] as $key => $value){
                if($payment_id==$value->id || $email==$value->email ||  $status==$value->status){
                    $html.='<tr>
                        <td>'.$value->id.'</td>
                        <td>'.$value->order_id.'</td>
                        <td>'.$value->amount.'</td>
                        <td>'.$value->email.'</td>
                        <td>'.$value->contact.'</td>
                        <td class="text-center" data-sort="'.date('d-m-Y',strtotime($value->created_at)).'">'.date('d-m-Y',strtotime($value->created_at)).'</td>
                        <td>'.$value->status.'</td>
                        <td class="text-center"><a class="btn btn-primary btn-sm" href="#"  title="Edit"><i class="fas fa-edit"></i></a></td>
                    </tr>';
                }
            }
        }
        return response()->json(array('html'=>$html));
    }

    public function searchorder(Request $request){
        $order_id = $request->order_id;
        $reciept = $request->reciept;
        $status = $request->status;
        $notes = $request->notes;
        $html = '';
        
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $all_orders = $api->order->all();

        if(!empty($all_orders->items)){
            foreach($all_orders->items as $order){
                if($order_id==$order['id'] || $reciept==$order['receipt'] ||  $status==$order['status']){
                    $html.='<tr>
                        <th scope="row">'.$order['id'].'</th>
                        <td>'.number_format($order['amount']/100,2).'</td>
                        <td>'.$order['attempts'].'</td>
                        <td>'.$order['receipt'].'</td>
                        <td>'.date("jS F, Y", $order['created_at']).'</td>
                        <td>
                            <a class="btn btn-sm btn-default">'.$order['status'].'</a>
                        </td>
                    </tr>';
                }
            }
        }
        return response()->json(array('html'=>$html));
    }

    public function searchrefund(Request $request){
        $payment_id = $request->payment_id;
        $refund_id = $request->refund_id;
        $status = $request->status;
        $notes = $request->notes;
        $html = '';
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $all_refunds = $api->refund->all();

        if(!empty($all_refunds->items)){
            foreach($all_refunds->items as $refund){
                if($payment_id==$refund['payment_id'] || $refund_id==$refund['id'] || $status==$refund['status'] || $notes==$refund['notes']){
                    $html.='<tr>
                        <th scope="row">'.$refund['id'].'</th>
                        <th scope="row">'.$refund['payment_id'].'</th>
                        <td>'.number_format($refund['amount']/100,2).'</td>
                        <td>'.date("jS F, Y", $refund['created_at']).'</td>
                        <td>
                            <a class="btn btn-sm btn-default">'.$refund['status'].'</a>
                        </td>
                    </tr>';
                }
            }
        }
        return response()->json(array('html'=>$html));
    }

    public function searchdispute(Request $request){
        $dispute_id = $request->dispute_id;
        $payment_id = $request->payment_id;
        $status = $request->status;
        $phase = $request->phase;
        $start_date = $request->start_date;
        $end_date = $request->end_date;



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/disputes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, 'rzp_test_YRAqXZOYgy9uyf' . ':' . 'uSaaMQw3jHK0MPtOnXCSSg51');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $all_disputes = json_decode($result, TRUE);
        curl_close($ch);

        $html = '';

        $start_date = DateTime::createFromFormat('d/m/Y', $start_date);
        if ($start_date === false) {
            $s_date='';
        } else {
            $s_date = $start_date->getTimestamp();
        }

        $end_date = DateTime::createFromFormat('d/m/Y', $end_date);
        if ($end_date === false) {
            $e_date='';
        } else {
            $e_date = $end_date->getTimestamp();
        }
        

        if(!empty($all_disputes['items'])){
            foreach($all_disputes['items'] as $dispute){
                if($dispute_id==$dispute['id'] || $payment_id==$dispute['payment_id'] ||  $status==$dispute['status'] ||  $phase==$dispute['phase'] || ($dispute['created_at']>=$s_date && $dispute['created_at']<=$e_date)){
                    $html.='<tr>
                        <th scope="row">'.$dispute['id'].'</th>
                        <th scope="row">'.$dispute['payment_id'].'</th>
                        <td>'.number_format($dispute['amount'],2).'</td>
                        <td>'.$dispute['reason_code'].'</td>
                        <td>'.date("jS F, Y", $dispute['respond_by']).'</td>
                        <td>'.date("jS F, Y", $dispute['created_at']).'</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">'.$dispute['status'].'</a>
                        </td>
                    </tr>';
                }
            }
        }
        return response()->json(array('html'=>$html));
    }

}
