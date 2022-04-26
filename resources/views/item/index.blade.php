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
		<input type="hidden" id="hidden_merchant_id" name="hidden_merchant_id">
		<div class="row">
			<div class="card-body">
				<div class="col-lg-3">
					<div class="form-group">
						@php 
						$get_all_merchants = Helpers::get_all_merchants();
						@endphp
						@if(!empty($get_all_merchants))
						<select class="form-control" id="header_merchant_id" onchange="get_table_data()">
						<option value="">Select Merchant</option>
						@foreach($get_all_merchants as $merchants)
						<option value="{{$merchants->id}}">{{$merchants->merchant_name}}</option>
						@endforeach
						</select>
						@endif
					</div>
				</div>
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
                        <td>{{$titem['id']}}</td>
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
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>


$("input#search").keyup(function () {
      alert("input#search");
});


function get_table_data(){
	var header_merchant_id = $("#header_merchant_id").val();
	$("#hidden_merchant_id").val(header_merchant_id);
	setTimeout(get_item_data, 1000);
}

function get_item_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getitemdata")}}',
        data: {'merchant_id': merchant_id},
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){
            $("#table_container").LoadingOverlay("hide", true);
            $("#table_container").html(data.html);
            $('#datatable1').DataTable();
        }
    });
}
</script>
@endsection
