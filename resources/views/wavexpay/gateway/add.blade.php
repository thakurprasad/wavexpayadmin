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
	
	<x-alert />

	<div class="card">
		<div class="card-header">
			<div class="pull-left">
                <h5>Add New Gateway Key &  Secret</h5>
	        </div>
        </div>

		<div class="card-body">
      	{!! Form::model($get, ['method' => 'POST', 'url' => 'gateway/create' ]) !!}  	
        @csrf
        <div class="row">
        	<div class="col-md-3">
                <div class="form-group">
					<label for="category_id">Category</label>
					<?php $ct = Helpers::get_api_key_categories() ?>
					 {!! Form::select('category_id', $ct , null, array('class' => 'form-control')) !!}
				</div>
            </div>

        	<div class="col-md-3">
                <div class="form-group">
					<label for="gateway">Gateway</label>
					 {!! Form::select('gateway', ['razorpay'=>'Razorpay'] , null, array('class' => 'form-control')) !!}
				</div>
            </div>            

			<div class="col-md-6">
                <div class="form-group">
					<label for="key_description">Key Description</label>
					 {!! Form::text('key_description', null, array('placeholder' => 'key_description','class' => 'form-control')) !!}
				</div>
			</div>

			<div class="col-md-3">
                <div class="form-group">
					<label for="api_key">Test API Key</label>
					 {!! Form::text('test_api_key', null, array('placeholder' => 'test_api_key','class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="api_secret">Test API Secret</label>
					{!! Form::text('test_api_secret', null, array('placeholder' => 'test_api_secret','class' => 'form-control')) !!}
				</div>
            </div>

			<div class="col-md-3">
                <div class="form-group">
					<label for="live_api_key">Live API Key</label>
					 {!! Form::text('live_api_key', null, array('placeholder' => 'live_api_key','class' => 'form-control')) !!}
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="live_api_secret">Live API Secret</label>
					{!! Form::text('live_api_secret', null, array('placeholder' => 'live_api_secret','class' => 'form-control')) !!}
				</div>
            </div>
           

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-warning" href="{{ url('gateway/list') }}"> Back</a>
            </div>
		</div>
		{!! Form::close() !!}
	</div>
@endsection
