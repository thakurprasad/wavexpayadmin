@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Item</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Item</li>
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
	@if ($message = Session::get('error'))
	<div class="alert alert-danger">
		<ul class="margin-bottom-none padding-left-lg">
			<li>{{ $message }} </li>
		</ul>
	</div>
	@endif
	<div class="card">
		<div class="card-header">
			<div class="pull-left">

	        </div>
	        <div class="pull-right">

	        </div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-sm" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    @if(!empty($data->items))
                    @foreach($data->items as $titem)
                    <tr id="item{{$titem['id']}}">
                        <th scope="row">{{$titem['id']}}</th>
                        <td>{{$titem['name']}}</td>
                        <td>{{$titem['description']}}</td>
                        <td>{{number_format(($titem['amount']/100),2)}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
			</table>
		</div>
	</div>

@endsection
@section('css')
@endsection
@section('js')

@endsection
