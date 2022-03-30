@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <h1>Page Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Pages</a></li>
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
                <h5>Edit Page</h5>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('pages.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
		@method('PATCH')
        <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="page_title">Page Title</label>
					<input type="text" class="form-control" name="page_title" id="page_title" required value="{{ $data->page_title }}"/>
				</div>
				<div class="form-group">
					<label for="meta_title">Meta Title</label>
					<input type="text" class="form-control" name="meta_title" id="meta_title" required value="{{ $data->meta_title }}"/>
				</div>
				<div class="form-group">
					<label for="meta_description">Meta Description</label>
					<input type="text" class="form-control" name="meta_description" id="meta_description" required value="{{ $data->meta_description }}"/>
				</div>
                <div class="form-group">
					<label for="banner_text">Banner Text</label>
					<input type="text" class="form-control" name="banner_text" id="banner_text" required value="{{ $data->banner_text }}"/>
				</div>
            </div>
            <div class="col-md-6">
				<div class="form-group">
					<label for="url_aliase">URL Aliase</label>
					<input type="text" class="form-control" name="url_aliase" id="url_aliase" required value="{{ $data->url_aliase }}"/>
				</div>
                <div class="form-group">
					<label for="meta_keywords">Meta Keywords</label>
					<input type="text" class="form-control" name="meta_keywords" id="meta_keywords" required value="{{ $data->meta_keywords }}"/>
				</div>
                <div class="form-group">
                    <label for="banner_image">Banner</label><br/>
					<div class="btn btn-default btn-file">
						<i class="fas fa-paperclip"></i> Upload
						<input type="file" id="banner_image" name="banner_image">
                  	</div>
				</div>
                <div class="form-group">
                    <img src="{{ asset('/storage/banner/'.$data->banner_image)}}" style="height:80px;" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-warning" href="{{ route('pages.index') }}"> Back</a>
            </div>
		</div>
        </form>
	</div>
@endsection
@section('css')
@endsection
@section('js')
<script>
    CKEDITOR.replace( 'content', {
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
