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
                <form class="col s12" id="search_form" method="POST" action="<?php url('/') ?>/transactions/searchorder">
                    @csrf
                    <input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
                    <div class="row">
                        <div class="col-md-3">
                            <input placeholder="Order Id" name="dispute_id" id="dispute_id" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input placeholder="Reciept" name="payment_id" id="payment_id" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input id="start_date" name="start_date" type="date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input id="end_date" name="end_date" type="text" class="form-control">
                        </div>
                        <div class="col-md-3" style="margin-top:18px;">
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="open">Open</option>
                                <option value="under_review">Under Review</option>
                                <option value="lost">Lost</option>
                                <option value="won">Won</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-top:18px;">
                            <select class="form-control" name="phase">
                                <option value="">Select Phase</option>
                                <option value="retrieval">Retrieval</option>
                                <option value="chargeback">Chargeback</option>
                                <option value="pre_arbitration">Pre Arbitration</option>
                                <option value="arbitration">Arbitration</option>
                                <option value="fraud">Fraud</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-top:18px;">                          
                            <button class="btn btn-sm btn-info" type="button" onclick="search_dispute()" name="action">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
			<br clear="all">
			<br clear="all">
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
                    @if(!empty($all_disputes['items']))
                    @foreach($all_disputes['items'] as $dispute)
                    <tr>
                        <th scope="row">{{$dispute['id']}}</th>
                        <th scope="row">{{$dispute['payment_id']}}</th>
                        <td>{{number_format($dispute['amount'],2)}}</td>
                        <td>{{$dispute['reason_code']}}</td>
                        <td>{{date("jS F, Y", $dispute['respond_by'])}}</td>
                        <td>{{date("jS F, Y", $dispute['created_at'])}}</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">{{$dispute['status']}}</a>
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


function get_dispute_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getdisputedata")}}',
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


function search_dispute(){
    $("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
    $.ajax({
        url: '{{url("searchdispute")}}',
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
@endsection
