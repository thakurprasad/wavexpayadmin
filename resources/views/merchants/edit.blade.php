@extends('layouts.admin')
@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <h1>Merchant Management</h1>
	</div>
	<div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
		<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('merchants.index') }}">Merchants</a></li>
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
                <h5>Edit Merchant</h5>
	        </div>
        </div>

		<div class="card-body">

    {!! Form::model($data, ['enctype'=>'multipart/form-data',
    'id'=>'merchant_edit_form' ,'method' => 'POST','route' => ['merchants.update', $data->id ]]) !!}
<!-- 
    	<form method="post" id="merchant_edit_form" action="{{ route('merchants.update', $data->id) }}" enctype="multipart/form-data"> -->
        @csrf
		@method('PATCH')
			<ul class="nav nav-tabs">
				<li class="home"><a id="gsettingclick" data-toggle="tab" href="#home">General Info</a></li>
				<li class="menu1"><a data-toggle="tab" href="#menu1">Bank Details</a></li>
				<li class="menu2"><a data-toggle="tab" href="#menu2">Business Overview</a></li>
				<li class="menu3"><a data-toggle="tab" href="#menu3">Business Details</a></li>
				<li class="menu4"><a data-toggle="tab" href="#menu4">Documents</a></li>
				<li class="menu5"><a data-toggle="tab" href="#menu5">Transaction Process</a></li>
			</ul>

			<div class="tab-content" style="padding-left:20px;">
				<div id="home" class="tab-pane fade in active">
					<div class="row" style="margin-top:10px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="merchant_name">Merchant Name/ Company Name</label>
								<input type="text" class="form-control" name="merchant_name" id="merchant_name" required value="{{ $data->merchant_name }}"/>
							</div>
							<div class="form-group">
								<label for="contact_name">Contact Name</label>
								<input type="text" class="form-control" name="contact_name" id="contact_name" required value="{{ $data->contact_name }}"/>
							</div>
							<div class="form-group">
								<label for="contact_phone">Contact Phone</label>
								<input type="text" class="form-control" name="contact_phone" id="contact_phone" required value="{{ $data->contact_phone }}"/>
							</div>

							<div class="form-group" style="display:none;">
								<label for="merchant_logo">Merchant Payment Method</label><br/>
								<select name="merchant_payment_method" class="form-control">
									<option value="">Select</option>
									<option value="razorpay" <?php if($data->merchant_payment_method=='razorpay') { echo 'selected'; } ?>>Razorpay</option>
									<option value="cashfree" <?php if($data->merchant_payment_method=='cashfree') { echo 'selected'; } ?>>Cashfree</option>
									<option value="paytm" <?php if($data->merchant_payment_method=='paytm') { echo 'selected'; } ?>>Paytm</option>
								</select>

							</div>
        	
		                <div class="form-group">
							<label for="wavexpay_api_key_id">Assign To Wavexpay api key for this Merchant</label><br>
							 {!! Form::select('wavexpay_api_key_id', App\Models\WavexpayApiKey::get_api_key_categories_arr() , null, array('class' => 'form-control')) !!}
						</div>
            
							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="access_salt">Access Salt</label>
								<input type="text" class="form-control" name="access_salt" id="access_salt" required value="{{ $data->access_salt }}"/>
							</div>
							<div class="form-group">
								<label for="status">Status</label><br/>
								<input name="status" id="status" data-id="0" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ ($data->status=='Active')? 'checked' : '' }}>
							</div>

							<div class="form-group">
								<label for="merchant_logo">Logo</label><br/>
								<div class="btn btn-default btn-file">
									<i class="fas fa-paperclip"></i> Upload
									<input type="file" accept="image/*" id="merchant_logo" name="merchant_logo">
								</div>
							</div>
							<div class="form-group">
								<img src="{{ asset('/uploads/logo/'.$data->merchant_logo)}}" style="height:80px;" />
							</div>
						</div>
						
					</div>
				</div>
				<div id="menu1" class="tab-pane fade">
					<div class="row" style="margin-top:10px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="merchant_name">Bneficiary Name</label>
								<input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name" required value="{{ $data->beneficiary_name }}"/>
							</div>
							<div class="form-group">
								<label for="contact_name">Ifsc Code</label>
								<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" required value="{{ $data->ifsc_code }}"/>
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="access_salt">Account Number</label>
								<input type="text" class="form-control" name="account_number" id="account_number" required value="{{ $data->account_number }}"/>
							</div>
						</div>
						
					</div>
				</div>
				<div id="menu2" class="tab-pane fade">
					<div class="row" style="margin-top:10px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="merchant_name">Business Type</label>
								<select class="form-control" id="business_type" name="business_type" id="exampleFormControlSelect1" required>
									<option value="notregistered" @if($data->business_type=='notregistered') selected @endif>Not yet Registerd</option>
									<option value="registered" @if($data->business_type=='registered') selected @endif>Registered</option>
								</select>
							</div>
							<div class="form-group">
								<label for="contact_name">Business Category</label>
								<select class="form-control" id="business_category" name="business_category" id="exampleFormControlSelect1" required>
									<option value="">Select</option>
									<option value="proprietorship" @if($data->business_category=='proprietorship') selected @endif>Proprietorship</option>
									<option value="partnership" @if($data->business_category=='partnership') selected @endif>Partnership</option>
									<option value="privatelimited" @if($data->business_category=='privatelimited') selected @endif>Private Limited</option>
									<option value="publiclimited" @if($data->business_category=='publiclimited') selected @endif>Public Limited</option>
									<option value="llp" @if($data->business_category=='llp') selected @endif>LLP</option>
									<option value="trust" @if($data->business_category=='trust') selected @endif>Trust</option>
								</select>
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="access_salt">Business Description</label>
								<textarea class="form-control" id="business_description" name="business_description" id="textAreaExample1" rows="4" placeholder="Minimum 50 characters" required>{{ $data->business_description }}</textarea>
								<small id="textareaHelp" class="form-text text-muted">Please give a brief description of the nature of your business. Please include examples of products you sell, the business category you operate under, your customers and the channels you primarily use to conduct your business(Website, offline retail etc).</small>
							</div>
						</div>
						
					</div>
				</div>
				<div id="menu3" class="tab-pane fade">
					<div class="row" style="margin-top:10px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="merchant_name">Pan Holder's Name</label>
								<input type="text" id="pan_holder_name" name="pan_holder_name" class="form-control name-text" id="exampleInputname1" value="{{ $data->pan_holder_name }}" placeholder="Enter name" required>
								<small id="nameHelp" class="form-text text-muted">We verify the deatils with the central Pan database. Please ensure you enter the correct details</small>
							</div>
							<div class="form-group">
								<label for="contact_name">Billing Label</label>
								<input type="text" id="billing_label" name="billing_label" class="form-control name-text" id="exampleInputname1"  value="" placeholder="Enter" value="{{ $data->billing_label }}" required>
							</div>
							<div class="form-group">
								<label for="contact_name">City</label>
								<input type="text" id="billing_city" name="billing_city" class="form-control name-text" id="exampleInputname1"  value="{{ $data->billing_city }}" placeholder="Enter city name" required>
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="access_salt">Address</label>
								<textarea class="form-control" id="billing_address" name="billing_address" id="textAreaExample1" rows="4"  value="" placeholder="Minimum 50 characters" required>{{ $data->billing_address }}</textarea>
							</div>
							<div class="form-group">
								<label for="contact_name">Pincode</label>
								<input type="text" id="billing_pincode" name="billing_pincode" class="form-control name-text" id="exampleInputname1"  value="{{ $data->billing_pincode }}" placeholder="Enter Pincode" required>
							</div>	
							<div class="form-group">
								<label for="contact_name">State</label>
								<input type="text" id="billing_state" name="billing_state" class="form-control name-text" id="exampleInputname1"  value="{{ $data->billing_state }}" placeholder="Enter State Name" required>
							</div>	
						</div>
						
					</div>
				</div>

				<div id="menu5" class="tab-pane fade">
					<div class="row" style="margin-top:10px;">			
					<?php $charges = App\Models\TransactionChargesMaster::all() ?>	
						@foreach($charges as $key=>$val)			
						<?php 
						if($data->transaction_charges_master_id == $val->id){
							$s = 'checked';
						}else{
							$s = '';
						}
						?>			
						<div class="col-md-3 text-center">	
							<div class=" charges-box {{ $s }}">
								<H5>{{ $val->interval }}</H5>
								<H2>{{ $val->charges }}%</H2><br>
								<div class="status-radio-button">
								<label>
									<input {{ $s }} type="radio" name="transaction_charges_master_id" value="{{ $val->id }}">	Selete
								</label>
								</div>
							</div>
						</div>

						@endforeach

					</div>
				</div>

				<div id="menu4" class="tab-pane fade">
					<div class="row" style="margin-top:10px;">
						<div class="col-md-6">
							<div class="form-group">
								<label for="merchant_name">Address Proof</label>
								<select class="form-control" id="address_proof" name="address_proof" id="exampleFormControlSelect1" required>
									<option value="aadhar" @if($data->address_proof=='aadhar') selected @endif>Aadhar</option>
									<option value="passport" @if($data->address_proof=='passport') selected @endif>Passport</option>
									<option value="voter_id" @if($data->address_proof=='voter_id') selected @endif>Voter id</option>
								</select>
							</div>
												
						</div>
						<div class="col-md-6" id="aadhar_upload_section">
						<div class="form-group">
								<label for="contact_name">Aadhar Front</label>
								<input type="file" name="aadhar_front" accept="image/*" class="form-control" id="aadhar_front_image">
								@if(isset($data->aadhar_front_image) && $data->aadhar_front_image!='')
								<img id="blah" src="{{$data->aadhar_front_image}}" alt="your image"  style="height:250px; width:400px;" />
								@else 
								<img id="blah" src="#" alt="your image"  style="height:100px; width:100px;" />
								@endif
								<br>
								<div class="status-radio-button">
								<label><input type="radio" name="aadhar_front_image_status" value="approved" onclick="show_reason('front','')" @if(isset($data->aadhar_front_image_status) && $data->aadhar_front_image_status=='approved') checked @endif>Approved</label>
								<label>
								<input type="radio" name="aadhar_front_image_status" value="pending" onclick="show_reason('front','')" @if(isset($data->aadhar_front_image_status) && $data->aadhar_front_image_status=='pending') checked @endif>Pending
								</label>
								<label>
								<input type="radio" name="aadhar_front_image_status" value="rejected" onclick="show_reason('front','reject')" @if(isset($data->aadhar_front_image_status) && $data->aadhar_front_image_status=='rejected') checked @endif>Rejected</label>
							</div>
								<br>
								<textarea class="form-control" name="aadhar_front_image_reject_reason" id="aadhar_front_image_reject_reason" style="display:@if(isset($data->aadhar_front_image_status) && $data->aadhar_front_image_status=='rejected') block; @else none; @endif" placeholder="Reject Reason">@if(isset($data->aadhar_front_image_status) && $data->aadhar_front_image_status=='rejected') {{$data->aadhar_front_image_reject_reason}} @endif</textarea>
							</div>
							<div class="form-group">
								<label for="contact_name">Aadhar Back</label>
								<input type="file" name="aadhar_back" accept="image/*" id="aadhar_back_image" class="form-control">
								@if(isset($data->aadhar_back_image) && $data->aadhar_back_image!='')
								<img id="blah2" src="{{$data->aadhar_back_image}}" alt="your image"  style="height:250px; width:400px;" />
								@else 
								<img id="blah2" src="#" alt="your image"  style="height:100px; width:100px;" />
								@endif
								<br>
								<div class="status-radio-button">
								<label>
								<input type="radio" name="aadhar_back_image_status" value="approved" onclick="show_reason('back','')" @if(isset($data->aadhar_back_image_status) && $data->aadhar_back_image_status=='approved') checked @endif>Approved
								</label>
								<label>
								<input type="radio" name="aadhar_back_image_status" value="pending" onclick="show_reason('back','')" @if(isset($data->aadhar_back_image_status) && $data->aadhar_back_image_status=='pending') checked @endif>Pending
								</label>
								<label>
								<input type="radio" name="aadhar_back_image_status" value="rejected" onclick="show_reason('back','reject')" @if(isset($data->aadhar_back_image_status) && $data->aadhar_back_image_status=='rejected') checked @endif>Rejected
								</label>
							</div>
								<br>
								<textarea class="form-control" name="aadhar_back_image_reject_reason" id="aadhar_back_image_reject_reason" style="display:@if(isset($data->aadhar_back_image_status) && $data->aadhar_back_image_status=='rejected') block; @else none; @endif" placeholder="Reject Reason">@if(isset($data->aadhar_back_image_status) && $data->aadhar_back_image_status=='rejected') {{$data->aadhar_back_image_reject_reason}} @endif</textarea>
								<small id="nameHelp" class="form-text text-muted">JPG/PNG of max size 2MB</small>
							</div>		
						</div>
										
<div class="col-md-6" id="other_doc_upload_section" style="display: _none;">
	<div class="form-group">
			<label for="contact_name">Uplaod Docment's image file</label>
			<input type="file" name="other_doc" accept="image/*" class="form-control" id="other_doc">
			@if(isset($data->other_doc) && $data->other_doc!='')
			<img id="blah" src="{{$data->other_doc}}" alt="your image"  style="height:250px; width:400px;" />
			@else 
			<img id="blah" src="#" alt="your image"  style="height:100px; width:100px;" />
			@endif
			<br>
		<div class="status-radio-button">
			<label><input type="radio" name="other_doc_status" value="approved" onclick="show_reason_other_doc('approved')" @if(isset($data->other_doc_status) && $data->other_doc_status=='approved') checked @endif>Approved</label>
			<label>
			<input type="radio" name="other_doc_status" value="pending" onclick="show_reason_other_doc('pending')" @if(isset($data->other_doc_status) && $data->other_doc_status=='pending') checked @endif>Pending
			</label>
			<label>
			<input type="radio" name="other_doc_status" value="rejected" onclick="show_reason_other_doc('rejected')" @if(isset($data->other_doc_status) && $data->other_doc_status=='rejected') checked @endif>Rejected</label>
		</div>
			<br>
			<textarea class="form-control" name="other_doc_reject_reason" id="other_doc_reject_reason" style="display:@if(isset($data->other_doc_status) && $data->other_doc_status=='rejected') block; @else none; @endif" placeholder="Reject Reason">@if(isset($data->other_doc_status) && $data->other_doc_status=='rejected') {{$data->other_doc_reject_reason}} @endif</textarea>
	</div>
</div>


					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12" style="margin-left: auto;margin-right: 0;">
				<button type="button" onclick="form_submit()" class="btn btn-primary">Update</button>
				<a class="btn btn-warning" href="{{ route('merchants.index') }}"> Back</a>
			</div>
    	<!-- </form> -->
    	{!! Form::close() !!}
	</div>
@endsection
@section('css')
<link href="{{ asset('/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
<style>
.charges-box {
    margin: 10px;
    border: 1px solid #ccc;
    padding: 30px 10px;
}

.charges-box.checked {
    border: 5px solid green;
    background: aliceblue;
}

.nav-tabs {
  list-style-type: none;
  margin: 0;
  padding: 10;
  overflow: hidden;
  background-color: #4b545c;
}

.nav-tabs li {
  float: left;
}

.nav-tabs li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.nav-tabs li a:hover:not(.active) {
  background-color: #111;
}

.nav-tabs .active {
  background-color: #4e73df;
}

.status-radio-button label {
    padding-right: 13px;
    background: #17a2b8;
    margin-top: 10px;
    margin-left: 10px;
    padding-left: 10px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}


</style>
@endsection
@section('js')
<script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
<script>
 <?php if($data->address_proof=='aadhar'){ ?>
 		$("#aadhar_upload_section").show(100);
    	$("#other_doc_upload_section").hide(100);
 <?php }else{ ?>
 	 $("#aadhar_upload_section").hide(100);
    $("#other_doc_upload_section").show(100);
 <?php } ?>

$("#address_proof").on('change', function(){
  if(this.value == 'aadhar'){
    $("#aadhar_upload_section").show(100);
    $("#other_doc_upload_section").hide(100);
  }else{
    $("#aadhar_upload_section").hide(100);
    $("#other_doc_upload_section").show(100);
  }
});


$(document).ready(function() {
    $("#gsettingclick").click();
});



function form_submit()
{
	$("#merchant_edit_form").submit();
}


$("#aadhar_front_image").change(function(){
    readURL(this);
});

$("#aadhar_back_image").change(function(){
    readURL2(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e1) {
            $('#blah').attr('src', e1.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader2 = new FileReader();

        reader2.onload = function (e2) {
            $('#blah2').attr('src', e2.target.result);
        }

        reader2.readAsDataURL(input.files[0]);
    }
}


function show_reason(type,action)
{
	if(action=='reject')
	{
		$("#aadhar_"+type+"_image_reject_reason").show();
	}
	else 
	{
		$("#aadhar_"+type+"_image_reject_reason").hide();
	}
}

function show_reason_other_doc(val){
	if(val == 'rejected'){
		$("#other_doc_reject_reason").show();
	}else{
		$("#other_doc_reject_reason").hide();
	}
}
</script>
@endsection
