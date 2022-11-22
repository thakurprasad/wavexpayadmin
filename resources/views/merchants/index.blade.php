@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Merchants</li>
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
			@can('setting-create')
	            <a class="btn btn-success" href="{{ route('merchants.create') }}"> Create New Merchant</a>
			@endcan
	        </div>
        </div>

		<div class="card-body">
			<form class="col s12" id="search_form" method="POST" action="<?php url('/') ?>/merchants/searchmerchant">
				@csrf
				<div class="row">
					<x-merchant-key-component />
					<div class="col-md-3">
						<input placeholder="Contact Person" id="contact_person" name="contact_person" type="text" class="form-control">
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
						<input placeholder="Phone" id="phone" name="phone" type="text" class="form-control">
					</div>
				
					<div class="col-md-3"> 
						<button class="btn btn-sm btn-info" onclick="search_merchant()" type="button" name="action">Submit</button>
					</div>
				</div>
			</form>
			<br clear="all"><br clear="all">
			<table class="table table-bordered table-sm" id="datatable">
				<thead>
					<tr class="text-center">
						<th>Merchant Name</th>
						<th>Contact Person</th>
						<th>Phone</th>
						<th>Status</th>
						<th>Payment Method</th>
						<th>Updated At</th>
						<th>Is Partner?</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="table_container">
				@foreach ($data as $key => $value)
				<tr>
					<td>{{ $value->merchant_name }}</td>
					<td>{{ $value->contact_name }}</td>
					<td>{{ $value->contact_phone }} </td>
					<td class="text-center"> <input data-id="{{$value->id}}" class="toggle-class  btn-xs" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($value->status=="Active")? "checked" : "" }} data-size="xs"> </td>
					<td class="text-center">{{ ucwords($value->merchant_payment_method) }} </td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->updated_at)) }}">{{ date('d-m-Y',strtotime($value->updated_at)) }}</td>
					<td class="text-center"> <input data-partner="{{$value->id}}" class="toggle-class partner-toggle btn-xs" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="yes" data-off="no" {{ ($value->is_partner=="yes")? "checked" : "" }} data-size="xs"> </td>
					<td class="text-center">
						@can('setting-edit')
						<a class="btn btn-primary btn-sm" href="{{ route('merchants.edit',$value->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
						@endcan
						@can('setting-delete')
						<form method="post" action="{{ route('merchants.destroy',$value->id) }}" style='display:inline' >
        				@csrf
                  		@method('DELETE')
						<button type="submit"  onclick="return confirm('Are you sure to Delete the data?');" class="btn btn-danger btn-sm"  title="Delete" ><i class="fas fa-trash"></i></button>
						</form>
						@endcan
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
@section('css')
<link href="{{ asset('/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset("/js/bootstrap-toggle.min.js") }}"></script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'Active' : 'Inactive';
        var id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/merchants/changestatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    });

	$('.partner-toggle').change(function() {
        var status = $(this).prop('checked') == true ? 'yes' : 'no';
        var id = $(this).data('partner');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/merchants/changespartnertatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
		
    });
  })


  


  function search_merchant(){
	$.ajax({
        url: '{{url("searchmerchant")}}',
        data: $("#search_form").serialize(),
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            $("#table_container").html(data.html);
            $('#datatable').DataTable();
			$('.toggle-class').bootstrapToggle();
			$('.partner-toggle').bootstrapToggle();
        }
    });
  }
</script>
@endsection
