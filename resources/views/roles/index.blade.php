@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Roles Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Roles</li>
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
			@can('role-create')
	            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
			@endcan
	        </div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-responsive-sm" id="datatable">
				<thead>
					<tr class="text-center">

						<th>Name</th>
						<th>Created At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($roles as $key => $role)
				<tr>

					<td>{{ strtoupper($role->name) }}</td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($role->created_at)) }}">{{ date('d-m-Y',strtotime($role->created_at)) }}</td>
					<td class="text-center">

						<!-- <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}" title="View"><i class="fas fa-play-circle"></i></a> -->
						@can('role-edit')
						<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
						@endcan
						@can('role-delete')
						<form method="post" action="{{ route('roles.destroy',$role->id) }}" style='display:inline' >
        				@csrf
                  		@method('DELETE')
						<button type="submit"  onclick="return confirm('Are you sure to Delete the Role?');" class="btn btn-danger"  title="Delete" ><i class="fas fa-trash"></i></button>
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
