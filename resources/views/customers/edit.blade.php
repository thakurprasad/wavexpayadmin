@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Customer Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
		<li class="breadcrumb-item active">Edit</li>
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
                <h5>Edit Customer</h5>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('customers.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
		@method('PATCH')
        <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="customer_name">Customer Name<span>*</span></label>
					<input type="text" class="form-control" name="customer_name" id="customer_name" required value="{{ $data->customer_name }}"/>
				</div>
				<div class="form-group">
					<label for="mobile">Mobile<span>*</span></label>
					<input type="text" class="form-control" name="mobile" id="mobile" required value="{{ $data->mobile }}"/>
				</div>
				<div class="form-group">
					<label for="mobile_2">Alternet Phone</label>
					<input type="text" class="form-control" name="mobile_2" id="mobile_2" value="{{ $data->mobile_2 }}"/>
				</div>
            </div>
            <div class="col-md-6">
				<div class="form-group">
					<label for="address">Address<span>*</span></label>
					<input type="text" class="form-control" name="address" id="address" required value="{{ $data->address }}"/>
				</div>
                <div class="form-group">
					<label for="locality">Locality<span>*</span></label>
					<input type="text" class="form-control" name="locality" id="locality" required value="{{ $data->locality }}"/>
				</div>
				<div class="form-group">
					<label for="status">Status</label><br/>
					<input name="status" id="status" data-id="0" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($data->status=='Active')? 'checked' : '' }}>
				</div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ route('customers.index') }}"> Back</a>
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
@endsection
