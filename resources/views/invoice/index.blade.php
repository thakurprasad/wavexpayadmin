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
            <x-filter-component form_id="search_form" action="invoice" method="POST" status="invoices"> 
                @section('advance_filters')
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="first_name">Invoice Id</label>
                            <input placeholder="Invoice ID" name="invoice_id" id="invoice_id" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="first_name">Reciept No</label>
                            <input placeholder="Reciept No" name="reciept_number" id="reciept_number" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="input-field col s3">
                        <label for="first_name">Customer Contact</label>
                        <input placeholder="Customer Contact" name="customer_contact" id="customer_contact" type="text" class="form-control">
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="first_name">Customer Email</label>
                            <input placeholder="Customer Email" name="customer_email" id="customer_email" type="text" class="form-control">
                        </div>
                    </div>
                @endsection
            </x-filter-component>


			    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Invoice Id</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Reciept</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Payment Links</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table_container">
                        @if(!empty($all_invoices))
                        @foreach($all_invoices as $invoice)
                        <?php

                            if(count($invoice->invoice_items)>0 ) {
                                 $amount = $invoice->invoice_items->sum('amount');
                            }else{
                                $amount = 0;
                            }
                                                        
                            if($invoice->customer){
                                $c = $invoice->customer;
                                $customer_details = $c->name .' | ' . $c->contact . ' | ' . $c->email;
                            }else{
                                $customer_details = '';
                            }

                        ?>
                        <tr>
                            <td><a style="color: blue;" href="{{ url('/invoice',$invoice->invoice_id) }}">{{ $invoice->invoice_id }}</a></td>
                            <td>{{ number_format($amount,2) }}</td>
                            <td>{{ $invoice->reciept }}</td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>{{ $customer_details }}</td>
                            <td>{{$invoice->short_url}}</td>
                            <td>{!! Helpers::badge($invoice->status) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>                        
                </table>
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


function get_table_data(){
	var header_merchant_id = $("#header_merchant_id").val();
	$("#hidden_merchant_id").val(header_merchant_id);
	//setTimeout(get_invoice_data, 1000);
}

function get_invoice_data(){
    var merchant_id = $("#header_merchant_id").val();
    if(merchant_id==''){
        alert('Please Select Merchant Id');
        return false;
    }
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getinvoicedata")}}',
        data: {'merchant_id': merchant_id},
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


function search_invoice(){
    var merchant_id = $("#header_merchant_id").val();
    if(merchant_id==''){
        alert('Please Select Merchant Id');
        return false;
    }
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
