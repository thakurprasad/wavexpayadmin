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
class InvoiceController extends Controller
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
    public function invoices(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->invoice->all();
        $data->items = [];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('invoice.index',compact('data'));
    }

    public function showInvoice($invoiceId){
        //echo $invoiceId;exit;
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $invoice_details = $api->invoice->fetch($invoiceId);

        $all_customers = $api->customer->all();
        $all_items = $api->Item->all();
        //print_r($invoice_details);exit;

        return view('invoice.details', compact('invoice_details','all_customers','all_items'));
    }

    public function items(Request $request)
    {
        $api = new Api('rzp_test_YRAqXZOYgy9uyf', 'uSaaMQw3jHK0MPtOnXCSSg51');
        $data = $api->item->all();
        $data->items = [];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true];
        return view('item.index',compact('data'));
    }

    public function searchInvoice(Request $request){
        $invoice_id = $request->invoice_id;
        $receipt = $request->reciept_number;
        $customer_contact = $request->customer_contact;
        $customer_email = $request->customer_email;

        
        $hidden_merchant_id = $request->hidden_merchant_id;
        $get_merchant_key_details = MerchantKey::where('id',$hidden_merchant_id)->first();
        $api_key = $get_merchant_key_details->api_key;
        $api_secret = $get_merchant_key_details->api_secret;
        $api = $api = new Api($api_key, $api_secret);
        $all_invoices = $api->invoice->all();

        $html = '';
        if(!empty($all_invoices->items)){
            foreach($all_invoices->items as $invoice){
                if($invoice_id==$invoice->id || $receipt==$invoice->receipt || $customer_contact==$invoice->customer_details->contact || $customer_email==$invoice->customer_details->email){
                    $html.='<tr>
                        <th scope="row">'.$invoice->id.'</th>
                        <td>'.number_format(($invoice->line_items[0]->net_amount)/100,2).'</td>
                        <td>'.$invoice->receipt.'</td>
                        <td>'.date('Y-m-d',$invoice->created_at).'</td>
                        <td>'.$invoice->customer_details->name.' ('.$invoice->customer_details->contact.'/ '.$invoice->customer_details->email.')</td>
                        <td>'.$invoice->short_url.'</td>
                        <td>';
                            if($invoice->status=='cancelled'){
                                $html.='<span class="new badge red">'.$invoice->status.'</span>';
                            }
                            else{
                                $html.='<span class="new badge blue">'.$invoice->status.'</span>';
                            }
                            $html.='</td>
                    </tr>';
                }
            }
        }
        return response()->json(array('html'=>$html));
    }

    public function getinvoicedata(Request $request){
        $merchant_id = $request->merchant_id;
        $get_merchant_key_details = MerchantKey::where('id',$merchant_id)->first();
        $api_key = $get_merchant_key_details->api_key;
        $api_secret = $get_merchant_key_details->api_secret;
        $api = $api = new Api($api_key, $api_secret);
        $all_invoices = $api->invoice->all();
        $html = '';
        if(!empty($all_invoices->items)){
            foreach($all_invoices->items as $invoice){
                $html.='<tr>
                    <td>'.$invoice->id.'</th>
                    <td>'.number_format(($invoice->line_items[0]->net_amount)/100,2).'</td>
                    <td>'.$invoice->receipt.'</td>
                    <td>'.date('Y-m-d',$invoice->created_at).'</td>
                    <td>'.$invoice->customer_details->name.' ('.$invoice->customer_details->contact.'/ '.$invoice->customer_details->email.')</td>
                    <td>'.$invoice->short_url.'</td>
                    <td>';
                        if($invoice->status=='cancelled'){
                            $html.='<span class="new badge red">'.$invoice->status.'</span>';
                        }
                        else{
                            $html.='<span class="new badge blue">'.$invoice->status.'</span>';
                        }
                        $html.='</td>
                </tr>';
            }
        }
        return response()->json(array('html'=>$html));
    }


    public function getitemdata(Request $request){
        $merchant_id = $request->merchant_id;
        $get_merchant_key_details = MerchantKey::where('id',$merchant_id)->first();
        $api_key = $get_merchant_key_details->api_key;
        $api_secret = $get_merchant_key_details->api_secret;
        $api = $api = new Api($api_key, $api_secret);
        $data = $api->item->all();
        $html='';
        if(!empty($data->items)){
            foreach($data->items as $titem){
                $html.='<tr>
                    <td>'.$titem['id'].'</td>
                    <td>'.$titem['name'].'</td>
                    <td>'.$titem['description'].'</td>
                    <td>'.number_format(($titem['amount']/100),2).'</td>
                </tr>';
            }
        }
        return response()->json(array('html'=>$html));
    }


}
