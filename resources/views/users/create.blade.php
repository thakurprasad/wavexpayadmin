@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Roles Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index')}}">Roles</a></li>
		<li class="breadcrumb-item active">Create</li>
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
    @if ($errors->any())
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
	@endif
	<div class="card">
		<div class="card-header">
			<div class="pull-left">
	            <h4>Create New Role</h4>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" required value="{{ old('name') }}" placeholder="Name" required/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" required value="{{ old('email') }}" placeholder="Email" required autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" name="phone" id="phone" required  value="{{ old('phone') }}" placeholder="Phone Number"  autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required value="" placeholder="Password" required autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" required value="" placeholder="Confirm Password" required autocomplete="off"/>
                </div>

                <div class="form-group">
                    <label for="role">Role(s)</label>
                    <select name="roles[]" id="role" class="form-control" multiple required>
                        <option value="">Select Role(s)</option>
                        @foreach($roles as $key=>$value)
						<option value="{{ $key}}">{{ strtoupper($value)}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="address_1">Address Line 1</label>
                    <input type="text" class="form-control" name="address_1" id="address_1" required  value="{{ old('address_1') }}" placeholder="Address"  autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="address_2">Address Line 2</label>
                    <input type="text" class="form-control" name="address_2" id="address_2" required  value="{{ old('address_2') }}" placeholder="Address"  autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city" required  value="{{ old('city') }}" placeholder="City"  autocomplete="off"/>
                </div>

                <div class="form-group">
                    <label for="pincode">Pin Code</label>
                    <input type="text" class="form-control" name="pincode" id="pincode" required  value="{{ old('pincode') }}" placeholder="Pin Code"  autocomplete="off"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-warning" href="{{ route('users.index')}}"> Back</a>
            </div>
		</div>
        </form>
	</div>
@endsection
@section('css')
<link href="{{ asset('/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset("/js/bootstrap-toggle.min.js") }}"></script>
<script type='text/javascript'>

</script>
@endsection
