@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Payments</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Merchant Payments</li>
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


	<div class="container">
		<x-filter-component form_id="search_form" action="payments" method="GET" status="payments"> 
			@section('advance_filters')
			<div class="col-sm-3">
					<div class="form-group">
						<label for="payment_id">Payment Id</label>
						<input type="text" name="payment_id" value="{{ app('request')->input('payment_id') }}" class="form-control" id="payment_id" placeholder="Payment Id">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" value="{{ app('request')->input('email') }}" type="email" class="form-control" id="email" placeholder="Email">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="email">Contact</label>
						<input type="text" name="contact" value="{{ app('request')->input('contact') }}" type="text" class="form-control" id="contact" placeholder="Contact">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="email">Payment Method</label>
						{!! Form::select('payment_method', Helpers::payment_method_arr() , null, array('class' => 'form-control', 'id'=>'payment_method' )) !!}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="email">Amount Range</label>
						<input type="text" value="{{ app('request')->input('amount_range') }}" name="amount_range" onkeyup="check_range()" class="form-control" id="amount_range" placeholder="Amount Range">
						<p style="color:green;">Ex: 200-400 (min-200 max-400)</p>
						<p style="color:red;" id="onkeyup_msg"></p>
					</div>
				</div>
			@endsection
		</x-filter-component>
		<table class="table table-bordered table-striped">
			<thead>
				<tr class="text-center">
					<th>Payment Id</th>
					<th>Amount</th>
					<th>Email</th>
					<th>Contact</th>
					<th>Payment Method</th>
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
				<td>{{ $value->payment_method }} </td>
				<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->created_at)) }}">{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
				<td>{!! Helpers::badge($value->status) !!} </td>
			</tr>
			@endforeach
			</tbody>
		</table>
		<div class="pagination">{!! $data->links() !!}</div>
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
			if(data.success==true){
				$("#table_container").LoadingOverlay("hide", true);
            	$("#table_container").html(data.html);
			}
            //$('#datatable1').DataTable();
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
@endsection
