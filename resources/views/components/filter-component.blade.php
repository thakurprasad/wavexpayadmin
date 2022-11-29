@php 
$payment_id = app('request')->input('payment_id');
$email = app('request')->input('email');
$contact = app('request')->input('contact');
$payment_method = app('request')->input('payment_method');
$amount_range = app('request')->input('amount_range');

$receipt = app('request')->input('receipt');
$refund_id = app('request')->input('refund_id');

$order_id = app('request')->input('order_id');

$dispute_id = app('request')->input('dispute_id');
@endphp
<form  method="{{ $method }}" action="{{$action}}" id="{{ $form_id }}">
  
        @csrf 
            <div class="row" style="padding-left: 10px;">
                <div class="col-sm-5">
                    <div class="form-group">
                        <x-date-range-picker id="daterangepicker" label="Select Date Range" />
                    </div>
                </div>
                <x-merchant-key-component />

                <x-dropdown-component status="{{$status}}" />
            </div>
          
            <div class="col-md-12"> 
                @if((isset($payment_id) && $payment_id!='') || (isset($email) && $email!='') || (isset($contact) && $contact!='') || (isset($payment_method) && $payment_method!='') || (isset($amount_range) && $amount_range!='') || (isset($receipt) && $receipt!='') || (isset($refund_id) && $refund_id!='') || (isset($order_id) && $order_id!='') || (isset($dispute_id) && $dispute_id!=''))
                <input type="button" onclick="show_hide('hide')" name="advance-filters" class="btn btn-link btn-sm hide-advance-filters" value="Hide Advance Filters">
                <input type="button" onclick="show_hide('show')" name="advance-filters" class="btn btn-link btn-sm show-advance-filters" value="Show Advance Filters" style="display: none;">
                @else
                <input type="button" onclick="show_hide('show')" name="advance-filters" class="btn btn-link btn-sm show-advance-filters" value="Show Advance Filters">
                <input type="button" onclick="show_hide('hide')" name="advance-filters" class="btn btn-link btn-sm hide-advance-filters" value="Hide Advance Filters" style="display: none;">
                @endif
            </div>
            @if((isset($payment_id) && $payment_id!='') || (isset($email) && $email!='') || (isset($contact) && $contact!='') || (isset($payment_method) && $payment_method!='') || (isset($amount_range) && $amount_range!='') || (isset($receipt) && $receipt!='') || (isset($refund_id) && $refund_id!='') || (isset($order_id) && $order_id!='') || (isset($dispute_id) && $dispute_id!=''))
            <div class="advance-filters">
            @else 
            <div class="advance-filters" style="display:none;">
            @endif
                <div class="row col-md-12">                  
                    @yield('advance_filters')
                </div>
            </div>

              <div class="row col-md-12" style="padding-left: 10px;">
                <div class="col-md-8"> </div>
                <div class="col-md-2 col-sm-2">
                    <div class="form-group pad-30">
                        <button type="submit" class="btn btn-primary btn-block" id="filter_data_btn">Serach</button>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <div class="form-group pad-30">
                        <button type="button" class="btn btn-secondary btn-block"  onclick="reset_page()" id="filter_reset_btn">Reset</button>
                    </div>
                </div>
            </div>

 
</form>

<script type="text/javascript">
    function show_hide(action){
        if(action == 'show'){
            $(".advance-filters").show(300);
            $(".show-advance-filters").hide(100);
            $(".hide-advance-filters").show(100);
        }else{
            $(".advance-filters").hide(300);
            $(".show-advance-filters").show(100);
            $(".hide-advance-filters").hide(100);
        }
    }

    function reset_page()
    {
        window.location = '{{url($action)}}';
    }
</script>

<style type="text/css">
.pad-30{
    padding-top: 30px;
}
 
#search_form{
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px 0px;
    background: #e3e6f0;

}
</style>