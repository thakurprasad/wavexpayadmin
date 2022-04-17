@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Invoices</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Invoices</li>
	</ol>
	</div>
</div>
@endsection
@section('content')
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<ul class="margin-bottom-none padding-left-lg">
			<li>{{ $message }}</li>
		</ul>
	</div>
	@endif
	@if ($message = Session::get('error'))
	<div class="alert alert-danger">
		<ul class="margin-bottom-none padding-left-lg">
			<li>{{ $message }} </li>
		</ul>
	</div>
	@endif
	<div class="card">
		<div class="card-header">
			<div class="pull-left">

	        </div>
	        <div class="pull-right">

	        </div>
        </div>

		<div class="card-body">
            <div class="row">
                <form id="form-edit-invoice" method="post">
                    <input type="hidden" id="edit_id" value="{{$invoice_details->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Invoice No</h6>
                            <input placeholder="Invoice #" name="invoice_no" id="invoice_no" type="text" class="form-control" required value="{{$invoice_details->id}}" readonly>
                            <span class="text-danger" id="nameError"></span>
                        </div>

                        <div class="col-md-6">
                            <h6>Invoice Description</h6>
                            <input placeholder="Enter Description" name="desscription" id="desscription" type="text" class="form-control" required value="{{$invoice_details->description}}">
                        </div>
                        <br clear="all">
                        <br clear="all">
                        <div class="col-md-6" style="margin-top:20px;">
                            <h6>BILLING TO</h6>
                            <select class="form-control" name="customer" id="customer">
                                <option value="" disabled>Select A Customer</option>
                                @if(!empty($all_customers->items))
                                @foreach($all_customers->items as $customer)
                                <option value="{{$customer->id}}" 
                                <?php 
                                if($customer->id==$invoice_details->customer_details->id) 
                                {
                                    echo 'selected="selected"';
                                }
                                ?>><strong>{{$customer->name}}</strong> ( {{$customer->email}} )</option>
                                @endforeach
                                @endif
                            </select>
                            {{$invoice_details->customer_details->contact}}<br>
                            {{$invoice_details->customer_details->email}}<br>
                        </div>
                        <div class="col-md-6" style="margin-top:20px;">
                            <h6>Billing Address</h6>
                            <p id="billing_address"></p>

                            <div class="row" id="billing_address_container">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="c_bil_add1" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->line1))
                                    {
                                        echo $invoice_details->customer_details->billing_address->line1;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="c_bil_add2" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->line2))
                                    {
                                        echo $invoice_details->customer_details->billing_address->line2;
                                    }
                                    ?>" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="c_bil_state" class="form-control" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->state))
                                    {
                                        echo $invoice_details->customer_details->billing_address->state;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_bil_city" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->city))
                                    {
                                        echo $invoice_details->customer_details->billing_address->city;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_bil_zip" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->zipcode))
                                    {
                                        echo $invoice_details->customer_details->billing_address->zipcode;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_bil_country" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->billing_address->country))
                                    {
                                        echo $invoice_details->customer_details->billing_address->country;
                                    }
                                    ?>">
                                </div>
                            </div>
                            <br clear="all">
                            <h6>Shipping Address</h6>
                            <p id="shipping_address"></p>
                            <div class="row" id="shipping_address_container">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="c_shi_add1" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->line1))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->line1;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="c_shi_add2" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->line2))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->line2;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_shi_state" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->state))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->state;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_shi_city" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->city))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->city;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_shi_zip" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->zipcode))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->zipcode;
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="c_shi_country" readonly value="<?php 
                                    if(isset($invoice_details->customer_details->shipping_address->country))
                                    {
                                        echo $invoice_details->customer_details->shipping_address->country;
                                    }
                                    ?>">
                                </div>
                            </div>
                        </div>
                        <br clear="all">
                        <br clear="all">
                        <div class="col-md-12"></div>
                        <div class="col-md-4" style="margin-top:20px;">
                            <h6>Issue Date</h6>
                            <input placeholder="Issue Date" name="issue_date" id="issue_date" type="date"  class="form-control" required value="<?php if(!empty($invoice_details->created_at)){
                                echo date('Y-m-d',$invoice_details->created_at);
                            } ?>">
                            
                        </div>
                        <div class="col-md-4" style="margin-top:20px;">
                            <h6>Expiry Date</h6>
                            <input placeholder="Expiry Date" name="expiry_date" id="expiry_date" type="date"  class="form-control" required value="<?php if(!empty($invoice_details->expire_by)){
                                echo date('Y-m-d',$invoice_details->expire_by);
                            } ?>"> 
                        </div>
                        <div class="col-md-4" style="margin-top:20px;">
                            <h6>Place Of Supply</h6>
                            <input placeholder="Place Of Supply" name="place_of_supply" id="place_of_supply" type="text"  class="form-control" required value="<?php if(!empty($invoice_details->supply_state_code)){
                                echo $invoice_details->supply_state_code;
                            } ?>">
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <h6>Customer Notes</h6>
                            <input placeholder="Customer Notes" name="customer_notes" id="customer_notes" type="text"  class="form-control" required value="<?php if(!empty($invoice_details->comment)){
                                echo $invoice_details->comment;
                            } ?>">
                            
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-12" style="margin-top:20px;">
                            <h6>Terms And Condition</h6>
                            <input placeholder="Terms And Condition" name="terms_condition" id="terms_condition" type="text"  class="form-control" required value="<?php if(!empty($invoice_details->terms)){
                                echo $invoice_details->terms;
                            } ?>">                           
                        </div>
                        <br clear="all">
                        <br clear="all">
                        <div class="col-md-12" style="margin-top:20px;">
                            <table id="item-table">
                                <tr>
                                    <th class="lineItem__item">DESCRIPTION</th>
                                    <th class="text-right lineItem__amount">RATE/ITEM</th>
                                    <th class="text-right lineItem__qty">QTY</th>
                                    <th class="text-right lineItem__total">TOTAL</th>
                                </tr>
                                <tbody>
                                    @if(!empty($invoice_details->line_items))
                                    @foreach($invoice_details->line_items as $item)
                                    <tr>
                                        <td>
                                            <select class="form-control" name="tableitem[]" id="tableitem{{$item->id}}" onchange="select_item('{{$item->id}}')">
                                                <option value="" disabled selected>Select An Item</option>
                                                @if(!empty($all_items->items))
                                                @foreach($all_items->items as $titem)
                                                <option value="{{$titem->id}}" 
                                                <?php 
                                                if($titem->name==$item->name)
                                                {
                                                    echo 'selected="selected"';
                                                }
                                                ?>
                                                ><strong>{{$titem->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span id="itd{{$titem->id}}">
                                            </span>
                                            
                                        </td>
                                        <td>
                                            <input type="text" name="item_rate[]" id="item_rate{{$item->id}}"  class="form-control" required value="{{ $item->amount/100 }}">
                                        </td>
                                        <td>
                                            <input type="number" min="1" name="item_qty[]" id="item_qty{{$item->id}}"  class="form-control" onclick="change_sub_amount('{{$item->id}}')" required value="{{ $item->quantity }}">
                                        </td>
                                        <td>
                                            <input type="text" name="item_total[]" id="item_total{{$item->id}}" class="form-control" required value="{{ $item->gross_amount/100 }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    <?php 
                                    for($i=1;$i<=10;$i++)
                                    {
                                    ?>
                                    <tr id="item_row_id{{$i}}" style="display:none;">
                                        <td>
                                            
                                            <select name="tableitem[]" id="tableitem{{$i}}" onchange="select_item('{{$i}}')">
                                                <option value="" disabled selected>Select An Item</option>
                                                @if(!empty($all_items->items))
                                                @foreach($all_items->items as $titem)
                                                <option value="{{$titem->id}}"><strong>{{$titem->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span id="itd{{$i}}">
                                            </span>
                                            <!--<a class="modal-trigger" href="#createitemmodal" onclick="item_row('{{$i}}')">+ Create New Item</a>-->
                                        </td>
                                        <td>
                                            <input type="text" name="item_rate[]" id="item_rate{{$i}}"  class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" min="1" name="item_qty[]" id="item_qty{{$i}}"  class="form-control" onclick="change_sub_amount('{{$i}}')" required>
                                        </td>
                                        <td>
                                            <input type="text" name="item_total[]" id="item_total{{$i}}"  class="form-control" required>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <table style="margin-top:20px;"><tr><td></td><td></td><td>Total Amount : </td><td><input type="text" id="total_amt" disabled value="{{ $invoice_details->amount/100 }}"></td></tr></table>
                    </div>
                </form>
            </div>
		</div>
	</div>

@endsection
@section('css')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
$(document).ready( function () {
    $('#datatable1').DataTable({
        "searching": false
    });
} );


function search_invoice(){
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    $.ajax({
        url: '{{url("searchinvoice")}}',
        data: $("#search_form").serialize(),
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            $("#table_container").LoadingOverlay("hide", true);
            $("#table_container").html(data.html);
            $('#datatable1').DataTable();
        }
    });
}

function reload_page(){
    location.reload();
}
</script>
@endsection
