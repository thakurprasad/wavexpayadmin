@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>My Profile</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
		<li class="breadcrumb-item active">Profile</li>
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
                <h5>Update Profile</h5>
	        </div>
        </div>
        <div class="card-body">
        <form method="POST" action="{{ route('change.profile') }}">
        @csrf
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ auth()->user()->name}}" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ auth()->user()->email}}" required>
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ auth()->user()->phone}}" >
                  </div>
                  <div class="form-group">
                    <label for="pincode">Pin Code</label>
                    <input id="pincode" type="text" class="form-control" name="pincode" value="{{ auth()->user()->pincode}}" >
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="address_1">Address Line 1</label>
                    <input id="address_1" type="text" class="form-control" name="address_1" value="{{ auth()->user()->address_1}}" >
                  </div>
                  <div class="form-group">
                    <label for="address_2">Address Line 2</label>
                    <input id="address_2" type="text" class="form-control" name="address_2" value="{{ auth()->user()->address_2}}" >
                  </div>
                  <div class="form-group">
                    <label for="city">City</label>
                    <input id="city" type="text" class="form-control" name="city" value="{{ auth()->user()->city}}" >
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
        </form>
        </div>
    </div>

@endsection
@section('js')
<script type='text/javascript'>

</script>
@endsection
