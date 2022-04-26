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
            <form class="col s12" method="POST" id="search_form" action="<?php url('/') ?>/searchinvoice">
                @csrf
                <input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            @php 
                            $get_all_merchants = Helpers::get_all_merchants();
                            @endphp
                            @if(!empty($get_all_merchants))
                            <select class="form-control" id="header_merchant_id" onchange="get_table_data()">
                            <option value="">Select Merchant</option>
                            @foreach($get_all_merchants as $merchants)
                            <option value="{{$merchants->id}}">{{$merchants->merchant_name}}</option>
                            @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input placeholder="Invoice ID" name="invoice_id" id="invoice_id" type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input placeholder="Reciept No" name="reciept_number" id="reciept_number" type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input placeholder="Customer Contact" name="customer_contact" id="customer_contact" type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input placeholder="Customer Email" name="customer_email" id="customer_email" type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input placeholder="Notes" name="notes" id="notes" type="text" class="form-control">
                    </div>
                    
                    <div class="col-md-1">                          
                        <button class="btn btn-sm btn-info" type="button" name="action" onclick="search_invoice()">Submit</button>
                    </div>

                    <div class="col-md-3">                          
                        <button class="btn btn-sm btn-default" type="button" name="action" onclick="reload_page()">Reset
                        </button>
                    </div>

                </div>
            </form>
			<br clear="all"><br clear="all">
			<table class="table table-bordered table-sm" id="datatable1">
                <thead>
                    <tr>
                    <th scope="col">Invoice Id</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Reciept No</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Payment Links</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    @if(!empty($data->items))
                    @foreach($data->items as $invoice)
                    <tr>
                        <td><a href="{{ url('/invoice',$invoice->id) }}">{{$invoice->id}}</a></th>
                        <td>{{number_format(($invoice->line_items[0]->net_amount)/100,2)}}</td>
                        <td>{{$invoice->receipt}}</td>
                        <td>{{date('Y-m-d',$invoice->created_at)}}</td>
                        <td>{{$invoice->customer_details->name}} ({{$invoice->customer_details->contact}} / {{$invoice->customer_details->email}})	</td>
                        <td>{{$invoice->short_url}}</td>
                        <td>
                            @if($invoice->status=='cancelled')
                            <span class="new badge red">{{$invoice->status}}</span>
                            @else
                            <span class="new badge blue">{{$invoice->status}}</span>
                            @endif
                        </td>
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
