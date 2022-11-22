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
			<x-filter-component form_id="search_form" action="searchpayments" method="POST" status="payments"> 
                @section('advance_filters')
                <div class="col-sm-3">
                        <div class="form-group">
                            <label for="payment_id">Payment Id</label>
                            <input type="text" name="payment_id" class="form-control" id="payment_id" placeholder="Payment Id">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>
					<div class="col-sm-3">
                        <div class="form-group">
                            <label for="email">Contact</label>
                            <input type="text" name="contact" type="text" class="form-control" id="contact" placeholder="Contact">
                        </div>
                    </div>
                @endsection
            </x-filter-component>
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


function search_data(){
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var start_date = $('#daterangepicker').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var end_date = $('#daterangepicker').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $.ajax({
        url: '{{url("searchpayment")}}',
        data: $("#search_form").serialize()+'&start_date='+start_date+'&end_date='+end_date,
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            $("#table_container").LoadingOverlay("hide", true);
            $("#table_container").html(data.html);
            //$('#datatable1').DataTable();
        }
    });
}

</script>
@endsection
