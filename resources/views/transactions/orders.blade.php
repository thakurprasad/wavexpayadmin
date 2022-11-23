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
			<x-filter-component form_id="search_form" action="orders" method="POST" status="orders"> 
				@section('advance_filters')
				<div class="col-sm-3">
					<div class="form-group">
						<label for="first_name">Order Id</label>
						<input placeholder="Order Id" name="order_id" id="order_id" type="text" class="form-control">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="first_name">Reciept</label>
						<input placeholder="Reciept" name="reciept" id="reciept" type="text" class="form-control">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="email">Amount Range</label>
						<input type="text" name="amount_range" onkeyup="check_range()" class="form-control" id="amount_range" placeholder="Amount Range">
						<p style="color:green;">Ex: 200-400 (min-200 max-400)</p>
						<p style="color:red;" id="onkeyup_msg"></p>
					</div>
				</div>
				@endsection
			</x-filter-component>
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


function search_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var start_date = $('#daterangepicker').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var end_date = $('#daterangepicker').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $.ajax({
        url: '{{url("searchorder")}}',
        data: $("#search_form").serialize()+'&start_date='+start_date+'&end_date='+end_date,
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            if(data.success==true){
				$("#table_container").LoadingOverlay("hide", true);
            	$("#table_container").html(data.html);
			}
        }
    });
}

function check_range(){
	var amount_range = $("#amount_range").val();
	if(amount_range.indexOf('-') == -1){
		$("#onkeyup_msg").html('enter - between two range');
		return false;
	}else{
		amount = amount_range.split("-");
		var min_amount = amount[0];
		var max_amount = amount[1];
		if(Number(min_amount)>Number(max_amount)){
			$("#onkeyup_msg").html('Min Amount Cannot Be Greater Than Max Amount');
		}else{
			$("#onkeyup_msg").html('');
		}
	}
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
