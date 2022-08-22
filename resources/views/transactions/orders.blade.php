@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Orders</h1>
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
			<div class="row">
				<form class="col s12" id="search_form" method="POST" action="<?php url('/') ?>/transactions/searchorder">
					@csrf
					<input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
					<div class="row">
						<div class="col-lg-3">
							<div class="form-group">
								@php 
								$get_all_merchants = Helpers::get_all_merchants();
								@endphp
								@if(!empty($get_all_merchants))
								<select class="form-control" name="header_merchant_id" id="header_merchant_id" onchange="get_table_data()">
								<option value="">Select Merchant</option>
								@foreach($get_all_merchants as $merchants)
								<option value="{{$merchants->id}}">{{$merchants->merchant_name}}</option>
								@endforeach
								</select>
								@endif
							</div>
						</div>
						<div class="col-md-3">
							<input placeholder="Order Id" name="order_id" id="order_id" type="text" class="form-control">
						</div>
						<div class="col-md-3">
							<input placeholder="Reciept" name="reciept" id="reciept" type="text" class="form-control">
						</div>
						<div class="col-md-3">
							<input placeholder="Notes" id="notes" name="notes" type="text" class="form-control">
						</div>
						<div class="col-md-3">
							<select class="form-control" name="status">
								<option value="" disabled selected>Choose your option</option>
								<option value="created">Created</option>
								<option value="accepted">Accepted</option>
								<option value="paid">Paid</option>
							</select>
						</div>
						<div class="col-md-3">                          
							<button class="btn btn-sm btn-info" type="button" onclick="search_order()" name="action">Submit</button>
						</div>
					</div>
				</form>
			</div>
			<br clear="all"><br clear="all">
			<table class="table table-bordered table-sm" id="datatable2">
				<thead>
					<tr class="text-center">
						<th>Order Id</th>
						<th>Amount</th>
						<th>Attempts</th>
                        <th>Receipt</th>
                        <th>Created At</th>
                        <th>Status</th>
					</tr>
				</thead>
				<tbody id="table_container">
				@foreach ($data as $value)
				<tr>
					<td>{{ $value->id }}</td>
					<td>{{ $value->amount }}</td>
                    <td>{{ $value->attempts }}</td>
                    <td>{{ $value->receipt }}</td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->created_at)) }}">{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
                    <td><a class="btn btn-sm btn-default">{{ $value->status }}</a></td>
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
    $('#datatable2').DataTable({
        "searching": false
    });
} );

function get_table_data(){
	var header_merchant_id = $("#header_merchant_id").val();
	$("#hidden_merchant_id").val(header_merchant_id);
	//setTimeout(get_orders_data, 1000);
}


function get_orders_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getorderdata")}}',
        data: {'merchant_id': merchant_id},
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            $("#table_container").LoadingOverlay("hide", true);
            $("#table_container").html(data.html);
            $('#datatable2').DataTable();
        }
    });
}


function search_order(){
	var merchant_id = $("#header_merchant_id").val();
    /*if(merchant_id==''){
        alert('Please Select Merchant Id');
        return false;
    }*/
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    $.ajax({
        url: '{{url("searchorder")}}',
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
</script>

<script>
    $(function(){
      $('#header_merchant_id').on('change', function () {
		get_orders_data();
      });
    });
</script>
@endsection
