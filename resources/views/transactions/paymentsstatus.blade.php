@extends('layouts.admin')
@section('title','Payments')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Payments Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
		<li class="breadcrumb-item active">Payments</li>
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
        <form class="col s12" id="search_form" method="POST" action="<?php url('/') ?>/transactions/searchpayments">
            @csrf
        <div class="card-body">
            <div class="row">
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
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="" disabled selected>Choose your option</option>
                            <option value="authorized">Authorized</option>
                            <option value="captured">Captured</option>
                            <option value="refunded">Refunded</option>
                            <option value="failed">Failed</option>
                            </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <input type="text" name="notes" class="form-control" id="notes" placeholder="Notes">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="button" class="btn btn-primary"  onclick="search_payment()">Submit</button>
            <button type="button" class="btn btn-info"  onclick="reset_page()">Reset</button>
        </div>
        </form>
    </div>

	<div class="card">
        <div class="card-body">

        </div>
		<div class="card-body">
			<table class="table table-bordered table-responsive-sm" id="datatable">
				<thead>
                    <tr>
                    <th scope="col">Payment Id</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    @if(!empty($all_payments))
                    @foreach($all_payments as $payment)
                    <tr>
                        <td>{{$payment->id}}</td>
                        <td>{{$payment->amount}}</td>
                        <td>{{$payment->email}}</td>
                        <td>{{$payment->contact}}</td>
                        <td>{{$payment->created_at}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
			</table>
		</div>
	</div>

@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection
@section('page-script')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable({
        "searching": false
    });
} );


function search_payment(){
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
            $('#myTable').DataTable();
        }
    });
}

function reset_page(){
    location.reload();
}
</script>
@endsection
