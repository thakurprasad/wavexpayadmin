@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Payments</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Merchant Transactions</li>
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
			<form class="col s12" id="search_form" method="POST" action="<?php url('/') ?>/transactions/searchpayments">
				@csrf
				<input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
				<div class="row">
					<x-merchant-key-component />
					<div class="col-md-3">
						<input placeholder="Payment ID" name="payment_id" id="payment_id" type="text" class="form-control">
					</div>
					<div class="col-md-3">
						<input placeholder="Email" id="email" name="email" type="text" class="form-control">
					</div>
					<div class="col-md-3">
						<select class="form-control" name="status">
							<option value="">Select Status</option>
							<option value="authorized">Authorized</option>
							<option value="captured">Captured</option>
							<option value="refunded">Refunded</option>
							<option value="failed">Failed</option>
						</select>
					</div>
					<div class="col-md-3">
						Start Date  <input id="start_date" name="start_date" type="date">
					</div>
					<div class="col-md-3">
						End Date  <input id="end_date" name="end_date" type="date">
					</div>
					<div class="col-md-3"> 
						<button class="btn btn-sm btn-info" onclick="search_payment()" type="button" name="action">Submit</button>
					</div>
				</div>
			</form>
			<br clear="all"><br clear="all">
			<table class="table table-bordered table-sm" id="datatable1">
				<thead>
					<tr class="text-center">
						<th>Payment Id</th>
						<th>Amount</th>
						<th>Email</th>
						<th>Contact</th>
                        <th>Created At</th>
                        <th>Status</th>
					</tr>
				</thead>
				<tbody id="table_container">
				@foreach ($data as  $value)
				<tr>
					<td>{{ $value->payment_id }}</td>
					<td>₹{{ $value->amount }} </td>
                    <td>{{ $value->email }} </td>
                    <td>{{ $value->contact }} </td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->created_at)) }}">{{ date('d-m-Y',strtotime($value->created_at)) }}</td>

                    <td>{{ $value->status }} </td>
				</tr>
				@endforeach
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
	//setTimeout(get_payment_data, 1000);
}

function get_payment_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getpaymentdata")}}',
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


function search_payment(){
	var merchant_id = $("#header_merchant_id").val();
    /*if(merchant_id==''){
        alert('Please Select Merchant Id');
        return false;
    }*/
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    $.ajax({
        url: '{{url("searchpayment")}}',
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


function get_merchants(){
	var key_id = $("#key_id").val();
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "{{url('/merchants/getmerchantsbykey')}}",
		data: {'key_id': key_id},
		headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
		success: function(data){
			$("#merchant_id").html(data.html);
		}
	});
}
</script>


<script>
    $(function(){
      $('#header_merchant_id').on('change', function () {
		get_payment_data();
      });
    });
</script>
@endsection
