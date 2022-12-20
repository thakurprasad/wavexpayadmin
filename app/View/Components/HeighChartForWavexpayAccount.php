<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Payment;
use DB;
use App\Models\DateList;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeighChartForWavexpayAccount extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $from_date;
    public $to_date;
    public $get;

    public function __construct()
    {
        $this->get = isset($_GET) ? array_filter($_GET) : [];
        $this->from_date = date('Y') . '-01-01';
        $this->to_date = date('Y') . '-12-31';
    }

    public function getData(){

        if(isset($this->get['daterangepicker'])){
            $date_arr = explode("-",$this->get['daterangepicker']);
            if(count($date_arr)>1){
              $this->from_date =  date('Y-m-d', strtotime($date_arr[0]));
              $this->to_date   =  date('Y-m-d', strtotime($date_arr[1]));             
            } 
        }

        
        $get = $this->get;

        $datediff = strtotime($this->to_date) - strtotime($this->from_date);
        $days =  round($datediff / (60 * 60 * 24));
        if($days <= 31) 
        {
            $get_date_format = "%d %b %Y";
        }else{
            $get_date_format = "%b %Y";    
        }
        

        #\DB::enableQueryLog();

         $data = Payment::select(
            'wavexpay_api_keys.key_description as accounts',
            DB::raw('sum(wxp_payments.amount) as amounts'),
            DB::raw('DATE_FORMAT(wxp_payments.payment_created_at, "'.$get_date_format.'") as dates')

        )->join('merchants', function($join){
            $join = $join->on( 'merchants.id', '=', 'payments.merchant_id');
         })->join('wavexpay_api_keys', function($join){
            $join = $join->on( 'wavexpay_api_keys.id', '=', 'payments.wavexpay_api_key_id');
         });
      /*  
        if($method != 'all'){
            $data = $data->where('payments.payment_method', $method);
        }*/
         
        if($this->from_date && $this->to_date){
            $data = $data->whereBetween(
                        DB::raw('date(wxp_payments.payment_created_at)'),
                        [$this->from_date, $this->to_date]
                    );
        }

        if(isset($get['status'])) {
            $data = $data->where('payments.status', $get['status']);
        }else{
            $data = $data->where('payments.status', 'captured');
        }
          
        if(isset($get['wavexpay_api_key_id'])){
            $data = $data->where('merchants.wavexpay_api_key_id', $get['wavexpay_api_key_id'] );
        }

        if(isset($get['merchant_id'])){
            $data = $data->where('merchants.id', $get['merchant_id']);
        }

        $data = $data->groupBy('dates', 'accounts')->orderBy('payments.payment_created_at', 'ASC');

       $data = $data->get();
    
   # dd(\DB::getQueryLog()); // Show       
      $ROWS = [];
      foreach ($data as $key => $row) {
        $account_name = $row->accounts;
        $date = $row->dates;
        $ROWS[$account_name][$date] = $row->amounts;
      }

    $date_list = DateList::select(
            DB::raw('DATE_FORMAT(date_col, "'.$get_date_format.'") as date')
        )->whereBetween('date_col', [$this->from_date, $this->to_date])->distinct()->get();
        $DATES = [];
       $DATA = [];
       foreach ($date_list as $key => $row) {
            $date = $row->date;
            $DATES[$date] = 0;
            if(count($ROWS) == 0){
                $DATA['None'][$date] = 0;  // if account not existing then fill on blank record
            }
            
        } 
        
        foreach ($ROWS as $name => $value) {
             
             foreach ($DATES as $date => $amount) {
                if(! isset($ROWS[$name][$date]) ){
                    $DATA[$name][$date] = $amount; // if not in row then fill amount 0   
                }else{
                    $DATA[$name][$date] = $ROWS[$name][$date]; // if in row then fill same amount      
                }                
             }
        }

       return $DATA;
    }

    public function render()
    {
       $data =  $this->getData();       
       $series = [];
       $dates = '';
       foreach ($data as $name => $value) {
           $dates = implode(",", array_keys($value) );
           $amounts = implode(",", array_values($value) );
           $dates = $dates;
           //$series[$name] = $amounts;
           $s['name'] = $name;
           $s['data'] =  array_values($value);
           $s['marker'] = (object)['symbol'=> 'diamond'];
           $series[] = $s;

       } 
       /*echo $dates; 
       dd($series); */
        return view('components.heigh-chart-for-wavexpay-account',
                 ['dates'=> $dates, 'series'=> json_encode($series) ]);
    }
}
