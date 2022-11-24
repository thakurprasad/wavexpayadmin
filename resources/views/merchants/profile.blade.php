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
			{!! $data !!}
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
                  <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Tab2</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Tab3</a></li>
                  
                  <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Tab3</a></li>

                  <li class="nav-item"><a class="nav-link" href="#tab4" data-toggle="tab">Tab4</a></li>

                  <li class="nav-item"><a class="nav-link" href="#tab5" data-toggle="tab">Tab5</a></li>

                  <li class="nav-item"><a class="nav-link" href="#tab6" data-toggle="tab">Tab6</a></li>

                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <div class="active tab-pane" id="tab1">
                    <h1>TAB1</h1>
                  </div>

                  <div class="tab-pane" id="tab2">
                  	<h1>Tab2</h1>
                  </div>

                   <div class="tab-pane" id="tab3">
                  	<h1>Tab3</h1>
                  </div>

                  <div class="tab-pane" id="tab4">
                  	<h1>Tab4</h1>
                  </div>

                  <div class="tab-pane" id="tab5">
                  	<h1>Tab5</h1>
                  </div>

                  <div class="tab-pane" id="tab6">
                  	<h1>Tab6</h1>
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
