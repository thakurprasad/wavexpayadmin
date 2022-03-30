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
    @yield('meta')
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
    <header class="home">
        <section class="header_top flight_booking">
            @include('includesites.header_top')
        </section>
        @yield('header_search')     
        
    </header>
    <!-- Header End -->

    <!-- Body Start -->
    <main>
    @yield('content')
    </main>
    <!-- Body End -->
    <!-- Body End -->

    <!-- Footer Start -->
    <footer>
        <section class="footer_top">
            <section class="newsletter_subscribe">
                @include('includesites.footer_newsletter')
            </section>

            <section class="footer_desc">
                @include('includesites.footer_content')
            </section>

            <section class="footer_bottom">
                @include('includesites.footer_link')
            </section>
        </section>

        <section class="footer_copy">
            <div class="container clearfix">
                <p>&copy; <?php echo date('Y');?>. All rights reserved. Designed & Developed by: Maxelerator Ltd</p>
            </div>
        </section>
    </footer>
    <!-- Footer End --> 
 
<a href="#"><img src="{{ asset('/images/chat.png')}}" alt="" class="chat"></a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('/css/animate.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/tab-style.css') }}" />
<script type="text/javascript" src="{{ asset('/js/jquery.multipurpose_tabcontent.js') }}"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('/css/zebra_datepicker.css') }}" />
<script src="{{ asset('/js/zebra_datepicker.min.js') }}"></script> 
<script src="{{ asset('/js/jquery.uniform.standalone.js') }}"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".first_tab").champ({
            plugin_type: "tab",
            //side: "right",
            active_tab: "1",
            controllers: "false"
        });

        $(".footer_tab").champ({
            plugin_type: "tab",
            //side: "right",
            active_tab: "1",
            controllers: "false"
        });

        $('#datepicker-formats').Zebra_DatePicker({
        	direction: 1,
	        format: 'M d, Y'
	    });
	    $('#datepicker-formats1').Zebra_DatePicker({
        	direction: 1,
	        format: 'M d, Y'
	    });

	    $( document ).ready(function() {
			$("select").uniform();
			$("input[type='radio']").uniform();
		});

		$('.cb-value').click(function() {
		  var mainParent = $(this).parent('.toggle-btn');
		  if($(mainParent).find('input.cb-value').is(':checked')) {
		    $(mainParent).addClass('active');
		  } else {
		    $(mainParent).removeClass('active');
		  }

		})

		$(window).scroll(function() {
		    if ($(this).scrollTop()>300)
		     {
		        $('.chat').show(100);
		     }
		    else
		     {
		      $('.chat').hide(100);
		     }
		});

		$( ".mobile_menu_header a" ).click(function(e) {
			e.preventDefault();
			$( "nav ul.navigation" ).slideToggle();
		});
   	});
</script>
@yield('js')  
</body>
</html>
