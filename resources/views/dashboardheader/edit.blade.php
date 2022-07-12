@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Dashboard Header</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboardheader.index')}}">Dashboard Header</a></li>
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
                <h5>Edit Dashboard Header</h5>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('dashboardheader.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
		@method('PATCH')
        <div class="row">
			<div class="col-md-6">
                <div class="form-group">
					<label for="state_name">Title</label>
					<input type="text" class="form-control" name="title" id="title" required value="{{ $data->title }}"/>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="country_id">Description</label>
					<textarea class="form-control" name="description">{{ $data->description }}</textarea>
				</div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ route('dashboardheader.index') }}"> Back</a>
            </div>
		</div>
        </form>
	</div>
@endsection
