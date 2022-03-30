@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>User Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Users</li>
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
			@can('user-create')
	            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
			@endcan
			</div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-responsive-sm" id="datatable">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Email</th>
						<th>Roles</th>
                        <th>Status</th>
						<th>Created At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $user)
				<tr>

					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td class="text-center">
					@if(!empty($user->getRoleNames()))
						@foreach($user->getRoleNames() as $v)
						<label class="badge badge-success">{{ strtoupper($v) }}</label>
						@endforeach
					@endif
					</td>
                    <td class="text-center"> <input data-id="{{$user->id}}" class="toggle-class  btn-sm" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($user->status=="1")? "checked" : "" }} data-size="xs"> </td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($user->created_at)) }}">{{ date('d-m-Y',strtotime($user->created_at)) }}</td>
					<td class="text-center">
						<!-- <a class="btn btn-info" href="{{ route('users.show',$user->id) }}" title="View"><i class="fas fa-play-circle"></i></a> -->
						@can('user-edit')
						<a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
						@endcan
						@can('user-delete')
						<form method="post" action="{{ route('users.destroy',$user->id) }}" style='display:inline' >
        				@csrf
                  		@method('DELETE')
						<button type="submit"  onclick="return confirm('Are you sure to Delete the User?');" class="btn btn-danger"  title="Delete" ><i class="fas fa-trash"></i></button>
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
<link href="{{ asset('/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset("/js/bootstrap-toggle.min.js") }}"></script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? '1' : '0';
        var id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/users/changestatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
@endsection
