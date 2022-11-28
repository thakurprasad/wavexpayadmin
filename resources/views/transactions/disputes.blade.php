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
            <x-filter-component form_id="search_form" action="disputes" method="POST" status="disputes"> 
                @section('advance_filters')
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="first_name">Dispute Id</label>
                        <input placeholder="Dispute Id" name="dispute_id" value="{{ app('request')->input('dispute_id') }}" id="dispute_id" type="text" class="form-control">
                    </div>  
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="first_name">Payment Id</label>
                        <input placeholder="Payment Id" name="payment_id" value="{{ app('request')->input('payment_id') }}" id="payment_id" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="first_name">Reason Code</label>
                        <input placeholder="Reason Code" name="reason_code" id="reason_code" type="text" class="form-control">
                    </div>  
                </div>
                <div class="col-sm-3">
					<div class="form-group">
						<label for="email">Amount Range</label>
						<input type="text" name="amount_range" value="{{ app('request')->input('amount_range') }}" onkeyup="check_range()" class="form-control" id="amount_range" placeholder="Amount Range">
						<p style="color:green;">Ex: 200-400 (min-200 max-400)</p>
						<p style="color:red;" id="onkeyup_msg"></p>
					</div>
				</div>
                @endsection
            </x-filter-component>
			<table class="table table-bordered table-sm" id="datatable1">
                <thead>
                    <tr>
                    <th scope="col">Dispute Id</th>
                    <th scope="col">Payment Id</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col">Respond By</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    @if(!empty($data))
                    @foreach($data as $dispute)
                    <tr>
                        <th scope="row">{{$dispute->id}}</th>
                        <th scope="row">{{$dispute->payment_id}}</th>
                        <td>{{number_format($dispute->amount,2)}}</td>
                        <td>{{$dispute->reason_code}}</td>
                        <td>{{date("jS F, Y", $dispute->respond_by)}}</td>
                        <td>{{date("jS F, Y", $dispute->created_at)}}</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">{!! Helpers::badge($dispute->status) !!}</a>
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
	setTimeout(get_dispute_data, 1000);
}


function search_data(){
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    var start_date = $('#daterangepicker').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var end_date = $('#daterangepicker').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $.ajax({
        url: '{{url("searchdispute")}}',
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
@endsection
