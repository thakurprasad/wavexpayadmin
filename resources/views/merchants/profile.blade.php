@extends('layouts.admin')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
	<h1>Merchant Profile</h1>
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
	@if ($message = Session::get('error'))
	<div class="alert alert-danger">
		<ul class="margin-bottom-none padding-left-lg">
			<li>{{ $message }} </li>
		</ul>
	</div>
	@endif
	<div class="card">

		<div class="card-body">

    <?php //print_r($data); exit; ?>
			<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <?php //print_r($data); exit; ?>
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{$data->merchant_name}}</h3>
                <h3 class="profile-username text-center">{{$data->MerchantUsers->email}}</h3>
                <h3 class="profile-username text-center">{{$data->contact_phone}}</h3>

                <p class="text-muted text-center">{{$data->MerchantUsers->display_name}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Pending</b> <a class="float-right">₹ {{Helpers::get_payment_data($data->id,'pending')}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Success</b> <a class="float-right">₹ {{Helpers::get_payment_data($data->id,'captured')}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Failure</b> <a class="float-right">₹ {{Helpers::get_payment_data($data->id,'failed')}}</a>
                  </li>
                </ul>

                <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <!--<div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>-->
              <!-- /.card-header -->
              
              
              <!--<div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>-->


              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Basic Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Address</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Payment Link</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab4" data-toggle="tab">Invoice</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab5" data-toggle="tab">Payments</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab6" data-toggle="tab">Items</a></li>

                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <div class="active tab-pane merchant-profile-section" id="tab1">

                    <div class="section">
                      <h4>Merchant Profile Deatils </h4>
                      <div class="col-md-12 row">
                         <div class="col-md-6">
                           <p><label><strong>Name: </strong></label> {{$data->MerchantUsers->name}}</p>
                           <p><label><strong>Mobile: </strong></label> {{$data->contact_phone}}</p>
                           <p><label><strong>Email: </strong></label> {{$data->MerchantUsers->email}}</p>
                           <p><label><strong>Email Verified At: </strong></label> {{$data->MerchantUsers->email_verified_at}}</p>
                           <p><label><strong>Status: </strong></label> {{$data->status }}</p>
                           <p><label><strong>is_partner: </strong></label> {{$data->is_partner}}</p>
                         </div>
                         <div class="col-md-6">                           
                           <p><label><strong>Merchant Logo: </strong></label> {{$data->merchant_logo}}</p>
                           <p><label><strong>Display Name: </strong></label> {{$data->MerchantUsers->display_name}}</p>
                           <p><label><strong>Assign Wavexpay Account: </strong></label> {{$data->wavexpay_api_key_id}}</p>
                           <p><label><strong>Referred By: </strong></label> {{$data->referred_by}}</p>
                           <p><label><strong>Created At: </strong></label> {{$data->created_at}}</p>                           
                         </div>
                      </div>
                    </div>

                    <div class="section">
                      <h4>Business Details </h4>
                      <div class="col-md-12 row">
                        <div class="col-md-6"> 
                           <p><label><strong>GST No.: </strong></label> {{$data->MerchantUsers->gst_no}}</p>
                           <p><label><strong>Business Type: </strong></label> {{$data->MerchantUsers->business_type}}</p>
                           <p><label><strong>Business Category: </strong></label> {{$data->MerchantUsers->business_category}}</p>
                           <p><label><strong>Business Description: </strong></label> {{$data->MerchantUsers->business_description}}</p>
                        </div>                        
                    </div>
                  </div>

                    <div class="section">
                      <h4>Bank Account Details </h4>
                      <div class="col-md-12 row">
                        <div class="col-md-6">
                           <p><label><strong>Beneficiary Name:</strong></label> {{$data->MerchantUsers->beneficiary_name}}</p>
                           <p><label><strong>IFSC Code: </strong></label> {{$data->MerchantUsers->ifsc_code}}</p>
                           <p><label><strong>Account Number: </strong></label> {{$data->MerchantUsers->account_number}}</p>
                        </div>                        
                    </div>
                  </div>

                  <div class="section">
                      <h4>Documents</h4>
                      <div class="col-md-12 row">
                        
                        <div class="col-md-6">
                          <label>Aadhar Front </label><br>
                          <img src="{{ $data->MerchantUsers->aadhar_front_image }}">
                        </div>

                        <div class="col-md-6">
                          <label>Aadhar Back</label><br>
                          <img src="{{$data->MerchantUsers->aadhar_back_image }}">
                        </div>

                        <div class="col-md-12">

                  <p><label><strong>Address Proof: </strong></label> {{$data->MerchantUsers->address_proof }}</p>

                  <p><label><strong>Aadhar no: </strong></label> {{$data->MerchantUsers->aadhar_no }}</p>
                  
                  <p><label><strong>Aadhar front image status: </strong></label> {{  $data->MerchantUsers->aadhar_front_image_status }}</p>
                  
                  @if($data->MerchantUsers->aadhar_front_image_status != 'approved')
                     <p><label><strong>Aadhar front image reject reason: </strong>
                     </label> {{ $data->MerchantUsers->aadhar_front_image_reject_reason }}</p>
                  @endif
                  
                  <p><label><strong>Aadhar back image status: </strong></label> {{$data->MerchantUsers->aadhar_back_image_status }}</p>
                  @if($data->MerchantUsers->aadhar_back_image_status != 'approved')
                    <p><label><strong>Aadhar back image reject reason: </strong></label> {{$data->MerchantUsers->aadhar_back_image_reject_reason }}</p>
                  @endif
                  <br>
                  <p><label><strong>pan_holder_name: </strong></label> {{$data->MerchantUsers->pan_holder_name }}</p>

                        </div>                        
                    </div>
                  </div>

                    
              </div>

                  <div class="tab-pane" id="tab2">
                  	@php 
                    $get_merchant_address = Helpers::get_merchant_address($data->id);
                    @endphp
                    <table class="table table-striped table-bordered" id="datatable1">
                      <thead>
                        <tr>
                          <th>Address Type</th>
                          <th>Address 1</th>
                          <th>Address 2</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Country</th>
                          <th>Zip</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(!empty($data->MerchantAddresses))
                      @foreach($data->MerchantAddresses as $address)
                      <tr>
                        <td>{{$address->address_type}}</td>
                        <td>{{$address->line_1}}</td>
                        <td>{{$address->line_2}}</td>
                        <td>{{$address->state}}</td>
                        <td>{{$address->city}}</td>
                        <td>{{$address->country}}</td>
                        <td>{{$address->zip}}</td>
                      </tr>
                      @endforeach
                      @else 
                      <tr><td colspan="6">No Item Found</td></tr>
                      @endif
                      </tbody>
                    </table>
                  </div>

                   <div class="tab-pane" id="tab3">
                    <table class="table table-striped table-bordered table-responsive" id="datatable2">
                      <thead>
                        <tr>
                          <th>Payment Link Id</th>
                          <th>Amount</th>
                          <th>Description</th>
                          <th>Reference Id</th>
                          <th>Short Url</th>
                          <th>Status</th>
                          <th>Created At</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($data->PaymentLinks) && count($data->PaymentLinks)>0)
                      @foreach($data->PaymentLinks as $plink)
                        <tr>
                          <td>{{$plink->payment_link_id}}</td>
                          <td>{{$plink->amount}}</td>
                          <td>{{$plink->description}}</td>
                          <td>{{$plink->reference_id}}</td>
                          <td>{{$plink->short_url}}</td>
                          <td>{!! Helpers::badge($plink->status) !!}</td>
                          <td>{{date('j F,Y',strtotime($plink->created_at))}}</td>
                        </tr>
                      @endforeach
                      @else 
                      <tr><td colspan="6">No Item Found</td></tr>
                      @endif
                      </tbody>
                    </table>
                  </div>

                  <div class="tab-pane" id="tab4">
                  	@if(!empty($data->Invoices))
                    @foreach($data->Invoices as $invoices)
                    <table class="table table-striped table-bordered">
                      <thead><strong>Invoice No:</strong>{{$invoices->invoice_id}}     <strong>Date:</strong> {{date('j F,Y',strtotime($invoices->created_at))}}</thead>
                      <tbody>
                        <table class="table table-striped table-bordered" id="datatable3">
                          <thead>
                            <tr>
                              <th>Item</th>
                              <th>Rate</th>
                              <th>Quantity</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                          @if(isset($invoices->invoice_items) && count($invoices->invoice_items)>0)
                          @foreach($invoices->invoice_items as $items)
                            <tr>
                              <td>{{$items->name}}</td>
                              <td>{{$items->amount}}</td>
                              <td>{{$items->quantity}}</td>
                              <td>{{$items->amount*$items->quantity}}</td>
                            </tr>
                          @endforeach
                          @else 
                          <tr><td colspan="4">No Item Found</td></tr>
                          @endif
                          </tbody>
                        </table>
                      </tbody>
                    </table>
                    @endforeach 
                    @endif
                  </div>

                  <div class="tab-pane" id="tab5">
                    <table class="table table-striped table-bordered table-responsive" id="datatable4">
                      <thead>
                        <tr>
                          <th>Payment Id</th>
                          <th>Amount</th>
                          <th>Email</th>
                          <th>Cantact</th>
                          <th>Status</th>
                          <th>Payment Method</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($data->Payments) && count($data->Payments)>0)
                      @foreach($data->Payments as $pmt)
                        <tr>
                          <td>{{$pmt->payment_id}}</td>
                          <td>{{$pmt->amount}}</td>
                          <td>{{$pmt->email}}</td>
                          <td>{{$pmt->contact}}</td>
                          <td>{!! Helpers::badge($pmt->status) !!}</td>
                          <td>{{$pmt->payment_method}}</td>
                        </tr>
                      @endforeach
                      @else 
                      <tr><td colspan="6">No Item Found</td></tr>
                      @endif
                      </tbody>
                    </table>
                  </div>

                  <div class="tab-pane" id="tab6">
                    <table class="table table-striped table-bordered" id="datatable5">
                      <thead>
                        <tr>
                          <th>Item Id</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($data->Items) && count($data->Items)>0)
                      @foreach($data->Items as $it)
                        <tr>
                          <td>{{$it->item_id}}</td>
                          <td>{{$it->name}}</td>
                          <td>{{$it->description}}</td>
                          <td>{{$it->amount}}</td>
                        </tr>
                      @endforeach
                      @else 
                      <tr><td colspan="6">No Item Found</td></tr>
                      @endif
                      </tbody>
                    </table>
                  </div>

 
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
		</div> <!-- end of card-body -->

	</div> <!-- end of card -->

@endsection

@section('css')
<style type="text/css">
  .merchant-profile-section p {
      margin-bottom: 0;
      /*border-bottom: 1px solid #ccc;*/
  }
  .merchant-profile-section .section {
      border-bottom: 1px solid #ccc;
      margin: 10px 0px;
      padding: 10px 0;
  }
  .merchant-profile-section img {
    width: 100%;
}
  </style>
@endsection

@section('js')
<script>
$(document).ready(function() {
  $('#datatable1').DataTable();

  $('#datatable2').DataTable();

  $('#datatable4').DataTable();

  $('#datatable5').DataTable();
});
</script>
@endsection
