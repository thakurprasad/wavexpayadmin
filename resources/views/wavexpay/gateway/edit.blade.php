@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Gateway Key Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ url('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('gateway/list')}}">Gateway Keys</a></li>
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
                <h5>Edit Gateway Key</h5>
	        </div>
        </div>

		<div class="card-body">
      	{!! Form::model($data, ['method' => 'POST', 'url' => 'gateway/update/'.$data->id ]) !!}  	
        @csrf
        <div class="row">
        	<div class="col-md-3">
                <div class="form-group">
					<label for="gateway">Gateway</label>
					 {!! Form::select('gateway', ['razorpay'=>'Razorpay'] , null, array('class' => 'form-control')) !!}
				</div>
            </div>
            
        	 <div class="col-md-3">
                <div class="form-group">
					<label for="mode">Mode</label>
					 {!! Form::select('mode', ['test'=>'Test', 'live'=>'Live'] , null, array('class' => 'form-control')) !!}
				</div>
            </div>

			<div class="col-md-3">
                <div class="form-group">
					<label for="api_key">API Key</label>
					 {!! Form::text('api_key', null, array('placeholder' => 'api_key','class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="api_secret">API Secret</label>
					{!! Form::text('api_secret', null, array('placeholder' => 'api_secret','class' => 'form-control')) !!}
				</div>
            </div>
           

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ url('gateway/list') }}"> Back</a>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
@endsection
