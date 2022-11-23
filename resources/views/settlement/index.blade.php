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
		<div class="card-body">
            <x-filter-component form_id="search_form"  action="searchsettlements" method="POST" status="settlements"> 
                @section('advance_filters')
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="payment_id">Settlement Id</label>
                            <input type="text" name="settlement_id" class="form-control" id="settlement_id" placeholder="Settleement Id">
                        </div>
                    </div>
                @endsection
            </x-filter-component>
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
<script>
function get_table_data(){
	var header_merchant_id = $("#header_merchant_id").val();
	$("#hidden_merchant_id").val(header_merchant_id);
	setTimeout(get_settlement_data, 1000);
}

function get_settlement_data(){
	$("#table_container").LoadingOverlay("show", {
        background  : "rgba(165, 190, 100, 0.5)"
    });
	var merchant_id = $("#hidden_merchant_id").val();
	$.ajax({
        url: '{{url("getsettlementdata")}}',
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
