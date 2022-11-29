@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Key Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Merchant Keys</li>
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
	            <a class="btn btn-success" href="{{ route('merchant-keys.create') }}"> Create New Merchant Key</a>
			@endcan
	        </div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-sm" id="datatable">
				<thead>
					<tr class="text-center">
						<th>Merchant Name</th>
						<th>Title</th>
						<th>API Key</th>
						<th>Updated At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $value)
				<tr>
					<td>{{ $value->merchant_name }}</td>
					<td>{{ $value->api_title }}</td>
					<td>{{ $value->api_key }} </td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->updated_at)) }}">{{ date('d-m-Y',strtotime($value->updated_at)) }}</td>
					<td class="text-center">
						
						<a class="btn btn-primary btn-sm" href="{{ route('merchant-keys.edit',$value->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
						
						
						
					</td>
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
@endsection
