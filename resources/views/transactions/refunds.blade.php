@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Transactions</h1>
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
		<div class="card-body">
			<div class="row">
				<form class="col s12" id="search_form" method="POST" action="{{ url('/') }}/transactions/searchrefunds">
					@csrf
					<input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
					<div class="row">
					<x-merchant-key-component />
					<div class="col-md-3">
							<input placeholder="Refund ID" name="refund_id" id="refund_id" type="text" class="form-control">
						</div>
						<div class="col-md-3">
							<input placeholder="Payment ID" name="payment_id" id="payment_id" type="text" class="form-control">
						</div>
						<div class="col-md-3">
							<select class="form-control" name="status">
							<option value="">Choose your option</option>
							<option value="processed">Processed</option>
							<option value="processing">Processing</option>
							<option value="failed">Failed</option>
							</select>
						</div>
						<div class="col-md-3">
							<input placeholder="Notes" id="notes" name="notes" type="text" class="form-control">
						</div>
						<div class="col-md-3">                          
							<button class="btn btn-sm btn-info" onclick="search_refund()" type="button" name="action">Submit</button>
						</div>

					</div>
				</form>
			</div>
			<br clear="all">
			<br clear="all">
			<table class="table table-bordered table-sm" id="datatable1">
				<thead>
					<tr class="text-center">
						<th>Refund Id</th>
						<th>Payment Id</th>
						<th>Amount</th>
                        <th>Created At</th>
                        <th>Status</th>
					</tr>
				</thead>
				<tbody id="table_container">
				@foreach ($data['items'] as $key => $value)
				<tr>
					<td>{{ $value->id }}</td>
					<td>{{ $value->payment_id }} </td>
					<td>{{ $value->amount }} </td>
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
    $('#datatable1').DataTable({
        "searching": false
    });
} );


function get_table_data(){
	var header_merchant_id = $("#header_merchant_id").val();
	$("#hidden_merchant_id").val(header_merchant_id);
	//setTimeout(get_refunds_data, 1000);
}

function get_refunds_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getrefunddata")}}',
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


function search_refund(){
	var merchant_id = $("#header_merchant_id").val();
    if(merchant_id==''){
        alert('Please Select Merchant Id');
        return false;
    }
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    $.ajax({
        url: '{{url("searchrefund")}}',
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
@endsection
