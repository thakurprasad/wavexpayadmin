<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Payment;
use DB;
use App\Models\DateList;

use Illuminate\Http\Request;
use Illuminate\Support\Str;



class HeighChart extends Component
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

    public function getData($method){

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

       # \DB::enableQueryLog(); 
/*
    SELECT
        DATE_FORMAT(wxp_payments.payment_created_at, "%b %Y") AS Dates,
        sum(wxp_payments.amount) AS Amounts
    FROM
    wxp_payments 
    JOIN wxp_merchants ON  `wxp_merchants`.`id` = `wxp_payments`.`merchant_id`
    WHERE
      `wxp_payments`.`status` = 'captured'
      and  `transaction_mode` = 'test'
      and `wxp_payments`.`merchant_id` = 2 
      AND  `wxp_merchants`.`wavexpay_api_key_id` = 1  
      AND `wxp_payments`.`payment_created_at` BETWEEN '2022-01-01' AND '2022-12-11' 
      GROUP BY 
      Dates
    ORDER BY
         `wxp_payments`.`payment_created_at` ASC;*/


         $data = Payment::select(
            DB::raw('sum(wxp_payments.amount) as Amounts'),
            DB::raw('DATE_FORMAT(wxp_payments.payment_created_at, "'.$get_date_format.'") as Dates')

        )->join('merchants', function($join) use($method){
            $join = $join->on( 'merchants.id', '=', 'payments.merchant_id');
         });
        
        if($method != 'all'){
            $data = $data->where('payments.payment_method', $method);
        }
         
        if($this->from_date && $this->to_date){
            $data = $data->whereBetween('payments.payment_created_at', [$this->from_date, $this->to_date]);
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

        $data = $data->groupBy('Dates')->orderBy('payments.payment_created_at', 'ASC');

       $data = $data->get();

      #  dd(\DB::getQueryLog()); // Show

      $date_list = DateList::select(
            DB::raw('DATE_FORMAT(date_col, "'.$get_date_format.'") as Dates')
        )->whereBetween('date_col', [$this->from_date, $this->to_date])->distinct()->get();
        $DATES = [];
        $AMOUNTS = [];
        // listing default dates
        foreach($date_list as $key => $row) {
            $DATES[] = $row->Dates;
            $index = Str::snake($row->Dates);
            $AMOUNTS[$index] = 0;
        }
        
        # overwrite amounts which found in payments query results 
        foreach ($data as $key => $row) {           
            $DATES1[] = $row->Dates;
            $index = Str::snake($row->Dates);
            $AMOUNTS[$index] =  $row->Amounts;
        }
        
       $AMOUNTS1        = array_values($AMOUNTS) ;
       $ARR['amounts']  = implode(",",$AMOUNTS1);
       $ARR['dates']    = implode(",",$DATES);
       return $ARR;
    }



    public function render()
    {
          $total      = $this->getData('all');
          $card       = $this->getData('card');
          $upi        = $this->getData('upi');
          $wallet     = $this->getData('wallet');
          $netbanking = $this->getData('netbanking');

          $dates          = $total['dates'];
          $total_amounts  = $total['amounts'];          
          $card_amounts   = $card['amounts'];
          $upi_amounts    = $upi['amounts'];
          $wallet_amounts = $wallet['amounts'];
          $netbanking_amounts = $netbanking['amounts'];
        
        return view('components.heigh-chart', ['dates'=> $dates, 'total_amounts'=> $total_amounts, 'card_amounts'=>$card_amounts, 'upi_amounts'=>$upi_amounts, 'wallet_amounts'=>$wallet_amounts, 'netbanking_amounts'=>$netbanking_amounts ]);
    }
}
