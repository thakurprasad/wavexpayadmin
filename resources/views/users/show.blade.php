@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>User Management </h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Users</a></li>
		<li class="breadcrumb-item active">View</li>
	</ol>
	</div>
</div>
@endsection
@section('content')

	<div class="card">
		<div class="card-header">
			<div class="pull-left">
                <h5>View Role</h5>
	        </div>
        </div>

		<div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    &nbsp;{{ $user->name }}
                </div>
                <div class="form-group">
                    <strong>Email:</strong>
                    &nbsp;{{ $user->email }}
                </div>

            </div>
            <div class="col-md-6">
                <strong>Roles:</strong>
                <div class="form-group">
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <a class="btn btn-warning" href="{{ URL::previous() }}"> Back</a>
            </div>
		</div>
	</div>
@endsection
