@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Email Template Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('email-templates.index') }}">Email Templates</a></li>
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
	            <h4>Create New Email Template</h4>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('email-templates.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" name="title" id="title" required value="{{ old('title') }}"/>
				</div>
				<div class="form-group">
					<label for="email_subject">Subject</label>
					<input type="text" class="form-control" name="email_subject" id="email_subject" required value="{{ old('email_subject') }}"/>
				</div>
            </div>
            <div class="col-md-6">
				<div class="form-group">
					<label for="template_code">Template Code</label>
					<input type="text" class="form-control" name="template_code" id="template_code" required value="{{ old('template_code') }}"/>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
					<label for="email_content">Content</label>
					<textarea name="email_content" id="email_content" rows="10" cols="80" style="visibility: hidden; display: none;">{{ old('email_content') }}</textarea><br/>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-warning" href="{{ route('email-templates.index') }}"> Back</a>
            </div>
		</div>
        </form>
	</div>

@endsection
@section('css')

@endsection
@section('js')
<script>
    CKEDITOR.replace( 'email_content', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form',
		allowedContent: {
		// Allow all content.
		$1: {
			elements: CKEDITOR.dtd,
			attributes: true,
			styles: true,
			classes: true
			}
		},
    });
</script>
@endsection
