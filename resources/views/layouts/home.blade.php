<!DOCTYPE html>
<!--
This is a Home Page Template.
-->
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('/img/fab.png') }}" sizes="32x32" />
	<link rel="icon" href="{{ asset('/img/fab.png') }}" sizes="192x192" />
	<link rel="apple-touch-icon-precomposed" href="{{ asset('/img/fab.png') }}" />
	<meta name="msapplication-TileImage" content="{{ asset('/img/fab.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel='stylesheet' href="{{ asset('/css/style.css') }}" media='all' />

    @yield('css')
</head>
<body>
   <!-- Header Start -->

    <!-- Header End -->


    <!-- Body Start -->
    <main>
        @yield('content')
    </main>
    <!-- Body End -->

    <!-- Footer Start -->
    <footer>
        <section class="footer_copy">
            <div class="container clearfix">
                <p>&copy; <?php echo date('Y');?>. All rights reserved. Designed & Developed by: WeClean Ltd</p>
            </div>
        </section>
    </footer>
    <!-- Footer End -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>

@yield('js')
</body>
</html>
