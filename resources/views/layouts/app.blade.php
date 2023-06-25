<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chittagong Port Vehicle Sticker System') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">

    <!-- stylesheets -->
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/all.css" >
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <!-- header starts --> 
        @include('layouts.header')
        <!-- header closed -->  


        <!-- newsticker starts -->
        @include('layouts.newsticker')
        <!-- newsticker closed -->
        

        @yield('content')

        @include('layouts.footer')        
    </div>

    <!-- Scripts -->
    <script src="{{url('/assets/cdn')}}/jquery-3.6.0.min.js"></script>
    <script src="{{url('/assets/cdn')}}/popper.min.js"></script>
    <script src="{{url('/assets/cdn')}}/bootstrap.min.js"></script>
       
    <script type="text/javascript">        
        $(document).ready(function(){
            
            // scrollTop
            $(".scrolltotop").on('click', function(){       
              $("html").animate({'scrollTop' : '0'}, 500);            
              return false;
            });

            $(window).scroll( function() {
              var windowpos = $(window).scrollTop();
              if( windowpos >= 50 ) {
                $("a.scrolltotop").fadeIn();
              }
              else {
                $("a.scrolltotop").fadeOut();   
              }
            });        
        });  
    </script>     
</body>
</html>
