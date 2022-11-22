<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf_token" content="{{ csrf_token() }}" />
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" href="{{ asset('/img/fab.png') }}" sizes="32x32" />
	<link rel="icon" href="{{ asset('/img/fab.png') }}" sizes="192x192" />
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset("/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/css/adminlte.css") }}">
  <link rel="stylesheet" href="{{ asset("/plugins/datatable/dataTables.bootstrap4.css") }}">
  <link rel="stylesheet" href="{{ asset("/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}"/>


  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset("/plugins/select2/css/select2.min.css") }}">
  <link rel="stylesheet" href="{{ asset("/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <style>
      .alert {
        padding: 0.25rem 0.25rem 0 0.75rem,
      }
  </style>
  @yield('css')

</head>
<body class="sidebar-mini" style="height: auto;">
<div class="wrapper">
  <!-- Header -->

  <!-- Navbar -->
  @include('includes.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('includes.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        @yield('content_header')
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          @yield('content')
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  @include('includes.right_sidebar')
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('includes.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset("/plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- Select2 -->
<script src="{{ asset("/plugins/select2/js/select2.full.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/js/adminlte.min.js") }}"></script>

<script type="text/javascript" src="{{ asset("/plugins/datatable/jquery.dataTables.js") }}"></script>
<script type="text/javascript" src="{{ asset("/plugins/datatable/dataTables.bootstrap4.js") }}"></script>

<script type="text/javascript" src="{{ asset("/plugins/moment/moment.min.js") }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@yield('js')

<script>

$(document).ready(function() {
  $('#datatable').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true
    });
    $('#search_dates').daterangepicker({
        autoApply:true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    $('#search_from_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply:true,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    $('#search_end_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply:true,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    $('#received_on').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        autoApply:true,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    $('#expected_delivery').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        autoApply:true,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });


} );
$('#search_button').on('click',function(){

    $('#is_export').val(0);
    $( "#search_form" ).submit();
});

$('#export_button').on('click',function(){

    $('#is_export').val(1);
    $( "#search_form" ).submit();
});
</script>

</body>
</html>
