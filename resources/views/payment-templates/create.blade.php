@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Payment Template Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payment-templates.index') }}">Payment Templates</a></li>
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
	            <h4>Create New Payment Template</h4>
	        </div>
        </div>

		<div class="card-body">
        <form method="post" action="{{ route('payment-templates.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" name="title" id="title" required value="{{ old('title') }}"/>
				</div>
				<div class="form-group">
					<label for="subtitle">Sub Title</label>
					<input type="text" class="form-control" name="subtitle" id="subtitle" required value="{{ old('subtitle') }}"/>
				</div>
				<div class="form-group">
					<label for="payment_type">Payment Type</label>
                    <select name="payment_type" id="payment_type" class="form-control" required>
                        <option value="0"> -- Select --</option>
						<option value="Page" {{ ('Page'==old('payment_type'))?'selected':''}}>Payment Page</option>
                        <option value="Link" {{ ('Link'==old('payment_type'))?'selected':''}}>Payment Link</option>
                        <option value="Button" {{ ('Button'==old('payment_type'))?'selected':''}}>Payment Button</option>
                    </select>
				</div>
            </div>
            <div class="col-md-6">

				<div class="form-group">
					<label for="status">Status</label><br/>
					<input name="status" id="status" data-id="0" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ (old('status')=='on')? 'checked' : '' }}>
				</div>
                <div class="form-group">
                    <label for="bg_image">Image Template</label><br/>
					<div class="btn btn-default btn-file">
						<i class="fas fa-paperclip"></i> Upload
						<input type="file" id="bg_image" name="bg_image">
                  	</div>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
					<label for="description">Page Content</label>
					<textarea name="description" id="description" rows="10" cols="80" style="visibility: hidden; display: none;">{{ old('description') }}</textarea><br/>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-warning" href="{{ route('payment-templates.index') }}"> Back</a>
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
<script>
    CKEDITOR.replace( 'description', {
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
