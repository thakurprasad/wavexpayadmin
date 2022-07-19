@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <h1>Merchant Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('merchants.index') }}">Merchants</a></li>
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
                <h5>Edit Merchant</h5>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('merchants.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
		@method('PATCH')
        <div class="row">
			<div class="col-md-6">
                <div class="form-group">
					<label for="merchant_name">Merchant Name/ Company Name</label>
					<input type="text" class="form-control" name="merchant_name" id="merchant_name" required value="{{ $data->merchant_name }}"/>
				</div>
				<div class="form-group">
					<label for="contact_name">Contact Name</label>
					<input type="text" class="form-control" name="contact_name" id="contact_name" required value="{{ $data->contact_name }}"/>
				</div>
                <div class="form-group">
					<label for="contact_phone">Contact Phone</label>
					<input type="text" class="form-control" name="contact_phone" id="contact_phone" required value="{{ $data->contact_phone }}"/>
				</div>
				<div class="form-group">
                    <label for="merchant_logo">Merchant Payment Method</label><br/>
					<select name="merchant_payment_method" class="form-control">
						<option value="">Select</option>
						<option value="razorpay" <?php if($data->merchant_payment_method=='razorpay') { echo 'selected'; } ?>>Razorpay</option>
						<option value="cashfree" <?php if($data->merchant_payment_method=='cashfree') { echo 'selected'; } ?>>Cashfree</option>
						<option value="paytm" <?php if($data->merchant_payment_method=='paytm') { echo 'selected'; } ?>>Paytm</option>
					</select>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="access_salt">Access Salt</label>
					<input type="text" class="form-control" name="access_salt" id="access_salt" required value="{{ $data->access_salt }}"/>
				</div>
				<div class="form-group">
					<label for="status">Status</label><br/>
					<input name="status" id="status" data-id="0" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($data->status=='Active')? 'checked' : '' }}>
				</div>

                <div class="form-group">
                    <label for="merchant_logo">Logo</label><br/>
					<div class="btn btn-default btn-file">
						<i class="fas fa-paperclip"></i> Upload
						<input type="file" id="merchant_logo" name="merchant_logo">
                  	</div>
				</div>
                <div class="form-group">
                    <img src="{{ asset('/storage/logo/'.$data->merchant_logo)}}" style="height:80px;" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ route('merchants.index') }}"> Back</a>
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
