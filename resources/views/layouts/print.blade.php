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
  <!-- Google Font: Source Sans Pro -->


  @yield('css')

</head>
<body style="padding:0;font-size: 1rem;vertical-align: top;width:400px; font-family: Helvetica, Arial and Verdana;">
    <div style="align-content: center;width:400px;">
        <img src="{{ asset('/images/logo/logo.png')}}" class="img-fluid mx-auto d-block"
           style="width:50%;border:0;align:center; margin:13px;">
    </div>
    <div class="wrapper">
        <section class="invoice">
            @yield('content')
        </section>
    </div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


@yield('js')


</body>
</html>
