@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Reward Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Merchant Reward Point</li>
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
			<table class="table table-bordered table-sm" id="datatable">
				<thead>
					<tr class="text-center">
						<th>Merchant Name</th>
						<th>Contact Persone</th>
						<th>Phone</th>
						<th>Payment Method</th>
                        <th>Reward Value</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $value)
				<tr>
					<td>{{ $value->merchant_name }}</td>
					<td>{{ $value->contact_name }}</td>
					<td>{{ $value->contact_phone }} </td>
					<td class="text-center">{{ ucwords($value->merchant_payment_method) }}</td>
                    <td>₹{{ $value->reward_value }}<br clear="all"><div id="update_div{{$value->id}}" style="display:none;"><input type="text" id="reward{{$value->id}}"><button class="btn btn-sm btn-success" onclick="update_reward_value('{{$value->id}}')">Update</button></div><button class="btn btn-sm btn-info" id="set_reward_button{{$value->id}}" onclick="set_reward_value('{{$value->id}}')">Update Reward Value</button></td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
@section('css')
<link href="{{ asset('/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@endsection
@section('js')
<script src="{{ asset('/js/bootstrap-toggle.min.js') }}"></script>
<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'Active' : 'Inactive';
        var id = $(this).data('id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/merchants/changestatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    });

	$('.partner-toggle').change(function() {
        var status = $(this).prop('checked') == true ? 'yes' : 'no';
        var id = $(this).data('partner');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{url('/merchants/changespartnertatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
		
    });


  })


  function set_reward_value(id)
  {
    $("#update_div"+id).show();
    $("#set_reward_button"+id).hide();
  }

  function update_reward_value(id)
  {
    var reward = $("#reward"+id).val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('/merchants/changerewardvalue')}}",
        data: {'reward': reward, 'id': id},
        success: function(data){
            alert(data.success);
            window.location.reload();
        }
    });
  }
</script>
@endsection
