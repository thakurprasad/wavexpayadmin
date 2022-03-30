@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <h1>Merchant Key Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('merchant-keys.index') }}">Merchant Keys</a></li>
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
                <h5>Edit Merchant Key</h5>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('merchant-keys.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
		@method('PATCH')
        <div class="row">
			<div class="col-md-6">
                <div class="form-group">
					<label for="merchant_name">Merchant Name/ Company Name</label>
					<input type="text" class="form-control" name="merchant_name" id="merchant_name" readonly value="{{ $data->merchant_name }}"/>
				</div>
				<div class="form-group">
					<label for="apititle">Title</label>
					<input type="text" class="form-control" name="apititle" id="apititle" readonly value="{{ $data->api_title }}"/>
				</div>
                <div class="form-group">
					<label for="api_key">API Key</label>
					<input type="text" class="form-control" name="api_key" id="api_key" required value="{{ $data->api_key }}"/>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ route('merchant-keys.index') }}"> Back</a>
            </div>
		</div>
        </form>
	</div>
@endsection
@section('css')
@endsection
@section('js')
@endsection
