<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
use Helpers;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Pages"], ['name' => "Blank Page"],
        ];

        $dashboard_header = DB::table('dashboardheader')->first();


        $merchant_id = '';
        $get_all_merchants = Helpers::get_all_merchants();
        if(count($get_all_merchants)>0)
        {
            $merchant_id = $get_all_merchants[0]->id;
        }
        

        $payments = DB::table('payments')->get();
        $orders = DB::table('orders')->get();
        $disputes = DB::table('disputes')->get();
        $refunds = DB::table('refunds')->get();
        $users = DB::table('users')->get();


        if($merchant_id!=''){
            $payments = DB::table('payments')->where('merchant_id',$merchant_id)->get();
            $orders = DB::table('orders')->where('merchant_id',$merchant_id)->get();
            $disputes = DB::table('disputes')->where('merchant_id',$merchant_id)->get();
            $refunds = DB::table('refunds')->where('merchant_id',$merchant_id)->get();
        }



        

        /*****************payment value calculation for payment line graph***********************/
        $query = DB::table('payments')->whereMonth('payment_created_at', date('m'));
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query->where('merchant_id',$merchant_id);
        }
        $query->whereYear('payment_created_at', date('Y'));

        $payment_current_month_data = $query->get(['amount','payment_created_at']);

        //print_r($payment_current_month_data);exit;
        $query2 = DB::table('payments')->orderBy('amount', 'desc');
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query2->where('merchant_id',$merchant_id);
        }
        $paymentmaxValue = $query->value('amount');




        $query3 = DB::table('payments')->orderBy('amount', 'asc');
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query3->where('merchant_id',$merchant_id);
        }
        $paymentminValue = $query3->value('amount');







        $paymentxvalue1='[';
        $paymentyvalue1='[';
        foreach($payment_current_month_data as $data)
        {
            $paymentxvalue1.="'".date('M',strtotime($data->payment_created_at)).date('d',strtotime($data->payment_created_at))."'".",";

            $paymentyvalue1.=$data->amount.',';
        }
        $paymentxvalue1=rtrim($paymentxvalue1,",");
        $paymentxvalue1.=']';

        $paymentyvalue1=rtrim($paymentyvalue1,",");
        $paymentyvalue1.=']';
        
        /*****************payment value end calculation for payment line graph***********************/


        /*****************order value calculation for total line graph***********************/
        $query4 = DB::table('orders')->whereMonth('order_created_at', date('m'));
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query4->where('merchant_id',$merchant_id);
        }
        $query4->whereYear('order_created_at', date('Y'));
        $order_current_month_data = $query4->get(['amount','order_created_at']);


        $query5 = DB::table('orders')->whereMonth('order_created_at', date('m'));
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query5->where('merchant_id',$merchant_id);
        }
        $query5->whereYear('order_created_at', date('Y'))->orderBy('amount', 'desc');
        $ordermaxValue = $query5->value('amount');



        $query6 = DB::table('orders')->whereMonth('order_created_at', date('m'));
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query6->where('merchant_id',$merchant_id);
        }
        $query6->whereYear('order_created_at', date('Y'))->orderBy('amount', 'asc');
        $orderminValue = $query6->value('amount');



        $orderxvalue1='[';
        $orderyvalue1='[';
        foreach($order_current_month_data as $data)
        {
            $orderxvalue1.="'".date('M',strtotime($data->order_created_at)).date('d',strtotime($data->order_created_at))."'".",";

            $orderyvalue1.=$data->amount.',';
        }
        $orderxvalue1=rtrim($orderxvalue1,",");
        $orderxvalue1.=']';

        $orderyvalue1=rtrim($orderyvalue1,",");
        $orderyvalue1.=']';
        /*****************order value end calculation for payment line graph***********************/


        /*************************** pie chart data for volume in each section *********************/
        $new_pie_chart_volume_data = "['Payment', ".count($payments)."],
        ['Refund', ".count($refunds)."],
        ['Orders', ".count($orders)."],
        ['Disputes', ".count($disputes)."]";
        /*************************** end of pie chart data for volume in each section **************/


        /*************************** Bar Chart Data For Payment ************************************/
        $xValue='[';
        $yValue='[';
        $query7 = DB::table('payments')->select(
            DB::raw("(SUM(amount)) as total_amount"),
            DB::raw("MONTHNAME(payment_created_at) as month_name")
        );
        if(isset($merchant_id) && $merchant_id!='')
        {
            $query7->where('merchant_id',$merchant_id);
        }
        $query7->whereYear('payment_created_at', date('Y'));
        $query7->groupBy('month_name');
       
        $payment_month_data = $query7->get();
        
        foreach($payment_month_data as $pd)
        {
            $xValue.='"'.$pd->month_name.'",';
            $yValue.=$pd->total_amount.',';
        }
        $xValue=rtrim($xValue,",");
        $xValue.=']';

        $yValue=rtrim($yValue,",");
        $yValue.=']';

        

        //var yValues = [200, 58, 125, 110, 175, 148, 221, 315, 112];
        //var barColors = ["red", "green","blue","orange","brown", "black", "beige", "yellow"];
        /*************************** End Bar Chart Data For Payment ********************************/
        if(count($payments)>0)
        {
            $success_perc = number_format(((count($payments)*100)/(count($payments)+count($orders)+count($disputes)+count($refunds))),2);
        }
        else
        {
            $success_perc = 0;
        }

        return view('home', compact('payments','orders','disputes','refunds','users','success_perc','paymentxvalue1','paymentyvalue1','paymentmaxValue','paymentminValue','ordermaxValue','orderminValue','orderxvalue1','orderyvalue1','new_pie_chart_volume_data','xValue','yValue','dashboard_header'));
    }


    public function getSuccessTransactionGraphData(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status_filter = $request->status_filter;
        $merchant_id = $request->merchant_id;

        $paymentxvalue1='';
        $paymentyvalue1='';

        $orderxvalue1='';
        $orderyvalue1='';

        


        if($status_filter=='' || $status_filter=='all'){
            $query = DB::table('payments')->select(
                DB::raw("(SUM(amount)) as total_amount"),
                DB::raw("DATE(payment_created_at) as date")
            );

            if(isset($merchant_id) && $merchant_id!='')
            {
                $query->where('merchant_id',$merchant_id);
            }

            $query->whereYear('payment_created_at', date('Y'));
            $query->whereBetween('payment_created_at', [$start_date, $end_date]);
            $query->orderBy('date', 'DESC');
            $query->groupBy('date');

            $payment_data = $query->get();
        }else{
            $query = DB::table('payments')->select(
                DB::raw("(SUM(amount)) as total_amount"),
                DB::raw("DATE(payment_created_at) as date")
            );

            if(isset($merchant_id) && $merchant_id!='')
            {
                $query->where('merchant_id',$merchant_id);
            }

            $query->whereYear('payment_created_at', date('Y'));
            $query->whereBetween('payment_created_at', [$start_date, $end_date]);
            $query->orderBy('date', 'DESC');
            $query->groupBy('date');
            $query->where('status',$status_filter);

            $payment_data = $query->get();
        }



        $order_query = DB::table('orders')->select(
            DB::raw("(SUM(amount)) as total_amount"),
            DB::raw("DATE(order_created_at) as date")
        );

        if(isset($merchant_id) && $merchant_id!='')
        {
            $order_query->where('merchant_id',$merchant_id);
        }

        $order_query->whereYear('order_created_at', date('Y'));
        $order_query->whereBetween('order_created_at', [$start_date, $end_date]);
        $order_query->orderBy('date', 'DESC');
        $order_query->groupBy('date');
        
        $order_data = $order_query->get();


        $total_order = count($order_data);
        $total_payment_amount = 0;

        foreach($payment_data as $data)
        {
            $paymentxvalue1.=date('F d',strtotime($data->date)).',';
            $paymentyvalue1.=$data->total_amount.',';
            $total_payment_amount+=$data->total_amount;
        }
        $paymentxvalue1=rtrim($paymentxvalue1,",");
        $paymentyvalue1=rtrim($paymentyvalue1,",");

        foreach($order_data as $odata)
        {
            $orderxvalue1.=date('F d',strtotime($odata->date)).',';
            $orderyvalue1.=$odata->total_amount.',';
        }
        $orderxvalue1=rtrim($orderxvalue1,",");
        $orderyvalue1=rtrim($orderyvalue1,",");

        //success percentage calculation
        $payments = DB::table('payments')->whereBetween('payment_created_at', [$start_date, $end_date])->get();
        $orders = DB::table('orders')->whereBetween('order_created_at', [$start_date, $end_date])->get();
        $disputes = DB::table('disputes')->whereBetween('created_at', [$start_date, $end_date])->get();
        $refunds = DB::table('refunds')->whereBetween('created_at', [$start_date, $end_date])->get();

        if(count($payments)>0)
        {
            $success_perc = number_format(((count($payments)*100)/(count($payments)+count($orders)+count($disputes)+count($refunds))),2);
        }
        else
        {
            $success_perc = 0;
        }
        
        //end success percentage calculation
        

        return response()->json(array('paymentxvalue1'=>$paymentxvalue1,'paymentyvalue1'=>$paymentyvalue1,'orderxvalue1'=>$orderxvalue1,'orderyvalue1'=>$orderyvalue1,'total_order'=>$total_order,'total_payment_amount'=>$total_payment_amount,'success_perc'=>$success_perc));
    }
}
