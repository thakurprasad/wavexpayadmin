@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Settlement</h1>
	</div>
	<div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item active">Settlement</li>
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
                    <th scope="col">Settlement Id</th>
                    <th scope="col">Fees</th>
                    <th scope="col">Tax</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="table_container">
                    @if(!empty($data->items))
                    @foreach($data->items as $settlement)
                    <tr>
                        <th scope="row">{{$settlement['id']}}</th>
                        <td>{{number_format($settlement['fees']/100,2)}}</td>
                        <td>{{number_format($settlement['tax']/100,2)}}</td></td>
                        <td>{{date('Y-m-d',$settlement['created_at'])}}</td>
                        <td>
                            <a class="waves-effect waves-light btn-small">{{$settlement['status']}}</a>
                            <a class="waves-effect waves-light btn-flat">Breakup</a>
                        </td>
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
