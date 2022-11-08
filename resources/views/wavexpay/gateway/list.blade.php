@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Gateway Keys Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Gateway Keys</li>
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
			@can('gateway-create')			
			@endcan
	            <a class="btn btn-success" href="{{ url('gateway/create') }}"> Create New gateway</a>
	        </div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-sm" id="datatable">
				<thead>
					<tr class="text-center">
						<th>Gateway Details</th>
						<th>Test API</th>
						<th>Live API</th>
						<th>Assign To Merchants</th>
						<th>Created At</th>
						<th>Updated At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $row)
				<tr>
					<td>
						<b>{{ $row->gateway  }}</b><br> 
						{{ $row->key_description }}
					</td>
					
					<td>
						<b>Key:</b> {{ Str::mask($row->test_api_key, '*', 5); }} <br>
						<b>Secret:</b> {{ Str::mask($row->test_api_secret, '*', 5); }} 
					 </td>
					
					<td>
						<b>Key:</b> {{ Str::mask($row->live_api_key, '*', 5); }}<br>
						<b>Secret :</b> {{ Str::mask($row->live_api_secret, '*', 5); }} 
					</td>
					<td>{{ $row->merchants_count }}</td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($row->created_at)) }}">
						{{ date('d-m-Y',strtotime($row->created_at)) }}
					</td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($row->updated_at)) }}">
						{{ date('d-m-Y',strtotime($row->updated_at)) }}
					</td>
					<td class="text-center">
						<a class="btn btn-primary btn-sm" href="{{ url('gateway/edit',$row->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
