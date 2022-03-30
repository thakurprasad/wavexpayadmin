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
	            <h4>Create New Merchant Key</h4>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('merchant-keys.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
				<div class="form-group">
					<label for="merchnat_id">Merchant Name/ Company Name</label>
                    <select name="merchnat_id" id="merchnat_id" class="form-control" required >
                        <option value="0">Select Merchant</option>
                        @foreach($merchants as $value)
						<option value="{{ $value->id}}" {{ ($value->id==old('merchnat_id'))?'selected':''}}>{{ $value->merchant_name}}</option>
                        @endforeach
                    </select>
				</div>
				<div class="form-group">
					<label for="api_title">Title</label>
					<select name="api_title" id="api_title" class="form-control" required >
                        <option value="0">Select Title</option>
                        @foreach($api_titles as $key=>$value)
						<option value="{{ $key}}" {{ ($key==old('api_title'))?'selected':''}}>{{ $value}}</option>
                        @endforeach
                    </select>
				</div>
                <div class="form-group">
					<label for="api_key">API Key</label>
					<input type="text" class="form-control" name="api_key" id="api_key" required value="{{ old('api_key') }}"/>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Save</button>
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
