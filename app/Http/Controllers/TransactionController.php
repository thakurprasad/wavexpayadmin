<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Merchant;
use App\Models\MerchantKey;
use App\Models\MerchantUser;
use App\Models\Payment;
use Razorpay\Api\Api;
use DateTime;
use Helpers;



class TransactionController extends Controller
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
    public function payments(Request $request)
    {
        try{
            $query = Payment::query();
            if(isset($request->payment_id) && $request->payment_id!=''){
                $query->where('payment_id',$request->payment_id);
            }if(isset($request->merchant_id) && $request->merchant_id!='' && $request->merchant_id!='all'){
                $query->where('merchant_id',$request->merchant_id);
            }if(isset($request->email) && $request->email!=''){
                $query->where('email',$request->email);
            }if(isset($request->status) && $request->status!=''){
                $query->where('status',$request->status);
            }if(isset($request->contact) && $request->contact!=''){
                $query->where('contact',$request->contact);
            }if(isset($request->payment_method) && $request->payment_method!=''){
                $query->where('payment_method',$request->payment_method);
            }if($request->daterangepicker!='' && $request->start_date!='' && $request->end_date!=''){
                $query->whereBetween('created_at', [$request->start_date." 00:00:00", $request->end_date." 23:59:59"]);
            }if(isset($request->amount_range) && $request->amount_range!=''){
                $amount = explode('-',$request->amount_range);
                $min = $amount[0];
                $max = $amount[1];
                $query->where('amount', '>=', $min)->where('amount', '<=', $max);
            }


            /*$data = Payment::with(['payment_details'])->get();*/

            $result = $query->paginate(10);
            $data = $result;

            $pageConfigs = ['pageHeader' => true];
            return view('transactions.payments',compact('data'));
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
        
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
        $data = DB::table('orders')->get();
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


    public function searchpayment(Request $request){
        try{
            $merchant_id = $request->merchant_id;
            $payment_id = $request->payment_id;
            $email = $request->email;
            $status = $request->status;
            $contact = $request->contact;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $daterangepicker = $request->daterangepicker;

            $html = '';
            $query = DB::table('payments');
            if($payment_id!=''){
                $query->where('payment_id',$payment_id);
            }if($merchant_id!=''){
                $query->where('merchant_id',$merchant_id);
            }if($email!=''){
                $query->where('email',$email);
            }if($status!=''){
                $query->where('status',$status);
            }if($contact!=''){
                $query->where('contact',$contact);
            }if($daterangepicker!='' && $start_date!='' && $end_date!=''){
                $query->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"]);
            }
            $result = $query->get();
            $data = $result;

            print_r($data);
            return view('transactions.payments',compact('data'));
            //return response()->json(array('success'=>true,'html'=>$html));
            //return $this->sendResponse($html,'Payment data');
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
    }


    public function searchorder(Request $request){
        try{
            $merchant_id = $request->merchant_id;
            $reciept = $request->reciept;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $daterangepicker = $request->daterangepicker;
            $html = '';       

            $query = DB::table('orders');
            if($merchant_id!=''){
                $query->where('merchant_id',$merchant_id);
            }if($reciept!=''){
                $query->where('receipt',$reciept);
            }if($daterangepicker!='' && $start_date!='' && $end_date!=''){
                $query->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"]);
            }
            $result = $query->get();

            if(!empty($data)){
                foreach($data as $order){
                    $html.='<tr>
                        <td>'.$order->id.'</th>
                        <td>'.$order->amount.'</td>
                        <td>'.$order->attempts.'</td>
                        <td>'.$order->receipt.'</td>
                        <td>'.$order->created_at.'</td>
                        <td>
                            <a class="btn btn-sm btn-default">'.$order->status.'</a>
                        </td>
                    </tr>';
                }
            }
            return response()->json(array('success'=>true,'html'=>$html));
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
    }

    public function searchrefund(Request $request){
        try{
            $merchant_id = $request->merchant_id;
            $payment_id = $request->payment_id;
            $refund_id = $request->refund_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $daterangepicker = $request->daterangepicker;
            $html='';


            $query = DB::table('refunds');
            if($merchant_id!=''){
                $query->where('merchant_id',$merchant_id);
            }if($payment_id!=''){
                $query->where('payment_id',$payment_id);
            }if($refund_id!=''){
                $query->where('refund_id',$refund_id);
            }if($daterangepicker!='' && $start_date!='' && $end_date!=''){
                $query->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"]);
            }
            $all_refunds = $query->get();

            if(!empty($all_refunds)){
                foreach($all_refunds as $refund){
                    $html.='<tr>
                        <th scope="row">'.$refund->refund_id.'</th>
                        <th scope="row">'.$refund->payment_id.'</th>
                        <td>'.number_format($refund->amount/100,2).'</td>
                        <td>'.date("jS F, Y", $refund->created_at).'</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">'.Helper::badge($refund->status).'</a>
                        </td>
                    </tr>';
                }
            }
            return response()->json(array('success'=>true,'html'=>$html));
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
    }


    public function searchdispute(Request $request){
        try{
            $merchant_id = $request->merchant_id;
            $dispute_id = $request->dispute_id;
            $payment_id = $request->payment_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $daterangepicker = $request->daterangepicker;


            $query = DB::table('disputes');
            if($merchant_id!=''){
                $query->where('merchant_id',$merchant_id);
            }if($dispute_id!=''){
                $query->where('dispute_id',$dispute_id);
            }if($payment_id!=''){
                $query->where('payment_id',$payment_id);
            }if($status!=''){
                $query->where('status',$status);
            }if($daterangepicker!='' && $start_date!='' && $end_date!=''){
                $query->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"]);
            }
            $all_disputes = $query->get();

            $html = '';

            if(!empty($all_disputes)){
                foreach($all_disputes as $dispute){
                    $html.='<tr>
                        <th scope="row">'.$dispute->id.'</th>
                        <th scope="row">'.$dispute->payment_id.'</th>
                        <td>'.number_format($dispute->amount,2).'</td>
                        <td>'.$dispute->reason_code.'</td>
                        <td>'.date("jS F, Y", $dispute->respond_by).'</td>
                        <td>'.date("jS F, Y", $dispute->created_at).'</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">'.Helper::badge($dispute['status']).'</a>
                        </td>
                    </tr>';
                }
            }
            return response()->json(array('success'=>true,'html'=>$html));
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
    }

}
