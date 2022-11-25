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

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{$data->merchant_name}}</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
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
              </div>
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
                  
                  <div class="active tab-pane" id="tab1">
                    <div class="row">


                      <div class="col-md-4">
                        <label><strong>Name : </strong></label> {{$data->merchant_name}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Contact Name : </strong></label> {{$data->contact_name}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Email : </strong></label>  {{$data->MerchantUsers->email}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Contact Phone : </strong></label> {{$data->contact_phone}}
                      </div>


                      <div class="col-md-4"></div>
                      <div class="col-md-4"></div>
                      <br><br>


                      <div class="col-md-4">
                        <label><strong>Beneficiary Name : </strong></label> {{$data->MerchantUsers->beneficiary_name}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>IFSC Code : </strong></label> {{$data->MerchantUsers->ifsc_code}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Account Number : </strong></label>  {{$data->MerchantUsers->account_number}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Pan Holder Name : </strong></label>  {{$data->MerchantUsers->pan_holder_name}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Aadhar No : </strong></label>  {{$data->MerchantUsers->aadhar_no}}
                      </div>
                      
                      <div class="col-md-4"></div>
                      <br><br>
                      
                      <div class="col-md-4">
                        <label><strong>Business Category : </strong></label> {{$data->MerchantUsers->business_category}}
                      </div>
                      <div class="col-md-4">
                        <label><strong>Business Description : </strong></label> {{$data->MerchantUsers->business_description}}
                      </div>

                      <div class="col-md-4"></div>
                      <br><br>

                    </div>
                  </div>

                  <div class="tab-pane" id="tab2">
                  	@php 
                    $get_merchant_address = Helpers::get_merchant_address($data->id);
                    @endphp
                    <table class="table table-striped table-bordered">
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
                      @if(!empty($get_merchant_address))
                      @foreach($get_merchant_address as $address)
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
                    <table class="table table-striped table-bordered table-responsive">
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
                        <table class="table table-striped table-bordered">
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
                    <table class="table table-striped table-bordered table-responsive">
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
                    <table class="table table-striped table-bordered">
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
