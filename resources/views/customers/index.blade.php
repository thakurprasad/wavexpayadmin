@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Customer Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Customers</li>
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
            <div>
                <form class="form-inline" id="search_form" method="get" action="{{ route('customers.index') }}" enctype="multipart/form-data">

                    <input type="hidden" name="is_export" id="is_export" value="0"/>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-auto mb-3">
                        <label class="sr-only" for="s_title">Name</label>
                            <input type="text" class="form-control" name="s_title" id="s_title" placeholder="Name"  value="{{ $postvalue['s_title']}}">
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-auto mb-3">
                        <label class="sr-only" for="s_mobile">Mobile</label>
                        <input type="text" class="form-control" name="s_mobile" id="s_mobile" placeholder="Mobile"  value="{{ $postvalue['s_mobile']}}">
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-auto mb-3">
                        <button type="button" class="form-control btn btn-primary" id="search_button">Search</button>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-auto mb-3">
                        <button type="button" class="form-control btn btn-warning float-right" id="export_button"><i class="fas fa-download"></i> Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<div class="pull-left">

	        </div>
	        <div class="pull-right">
			@can('customer-create')
	            <a class="btn btn-success" href="{{ route('customers.create') }}"> Create New Customer</a>
			@endcan
	        </div>
        </div>

		<div class="card-body">
			<table class="table table-bordered table-responsive-sm">
				<thead>
					<tr class="text-center">
						<th>@sortablelink('customer_name','Customer Name')</th>
						<th>@sortablelink('mobile','Mobile')</th>
						<th>@sortablelink('mobile_2','Alternet Number')</th>
						<th>@sortablelink('address','Address')</th>
						<th>@sortablelink('locality','Locality')</th>
                        <th>@sortablelink('status','Status')</th>
						<th>@sortablelink('updated_at','Updated At')</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $value)
				<tr>
					<td>{{ $value->customer_name }}</td>
					<td>{{ $value->mobile }}</td>
					<td>{{ $value->mobile_2 }} </td>
					<td>{{ $value->address }}</td>
                    <td>{{ $value->locality }}</td>
					<td class="text-center"> <input data-id="{{$value->id}}" class="toggle-class  btn-sm" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($value->status=="Active")? "checked" : "" }} data-size="xs"> </td>
					<td class="text-center" data-sort="{{ date('d-m-Y',strtotime($value->updated_at)) }}">{{ date('d-m-Y',strtotime($value->updated_at)) }}</td>
					<td class="text-center">
						<!-- <a class="btn btn-info btn-sm" href="{{ route('customers.show',$value->id) }}" title="View"><i class="fas fa-play-circle"></i></a> -->
						@can('customer-edit')
						<a class="btn btn-primary btn-sm" href="{{ route('customers.edit',$value->id) }}"  title="Edit"><i class="fas fa-edit"></i></a>
						@endcan
						@can('customer-delete')
						<form method="post" action="{{ route('customers.destroy',$value->id) }}" style='display:inline' >
        				@csrf
                  		@method('DELETE')
						<button type="submit"  onclick="return confirm('Are you sure to Delete the Record?');" class="btn btn-danger btn-sm"  title="Delete" ><i class="fas fa-trash"></i></button>
						</form>
						@endcan
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
            <br/>
            {!! $data->appends(\Request::except('page'))->render() !!}
            <p>
                Displaying {{$data->count()}} of {{ $data->total() }} customer(s).
            </p>
		</div>
	</div>

@endsection
@section('css')
<link href="{{ asset('/css/bootstrap-toggle.min.css') }}" rel="stylesheet">

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
            url: "{{url('/customers/changestatus')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  });

</script>
@endsection
