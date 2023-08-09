<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Home | Station Headquarters Dhaka Cantonment, Dhaka</title>
    
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/LogoS1.png')}}"/>
    
    <link href="{{url('/assets/cdn')}}/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/responsive-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/customer-css.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/front-style.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{url('/assets/cdn')}}/toastr.css">
    <style>
        span.mrq-text a {
            color: #fff;
        }

        span.mrq-text a {
            color: #fff;
        }

        span.mrq-text a:hover {
            color: #a22f18;
            border-bottom: 1px solid #A22F18;
        }

        .notice-description {
            text-align: justify;
            padding: 14px 0;
            font-size: 15px;
        }

        a.notice-alert {
            background: #A22F18;
            display: block;
            color: #fff;
            padding: 7px 13px;
        }

        a.blink_me {
            animation: blinker 3s linear infinite;
        }

        @keyframes blinker {
            0% {
                opacity: 1;
            }
            75% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        .notice-area {
            position: relative;
        }

        .notice-area a {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 99;
            padding: 8px 4px;
        }

        span.notice-text {
            font-size: 15px;
        }

        /*first animation start*/
    </style>
</head>
<body>
<div>
    
    <!-- header starts -->
@include('layouts.header')
<!-- header closed -->
@include('layouts.newsticker')
    
    <div class="wrapper main-content" id="app-main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    
                    <div class="sidebar" id="app-sidebar" style="background-color: #1B9C4E;">
                      
                    <img src="{{isset(auth()->guard('applicant')->user()->applicantDetail->applicant_photo) ? auth()->guard('applicant')->user()->applicantDetail->applicant_photo : ''}}"
                             class="img-fluid" height="150" width="150" alt="">
                        <h5>{{isset(auth()->guard('applicant')->user()->name) ? auth()->guard('applicant')->user()->name : ''}}</h5>
                        <a href="{{url('/about/customer')}}">Dashboard</a>
                        <a href="{{url('/customer/home')}}">Apply for Another Sticker</a>
                        <a href="{{url('/applied-applications')}}">Applied Applications</a>
                        <a href="{{url('/alocated-stickers')}}">Allocated Stickers</a>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>

<script src="{{url('/assets/cdn')}}/jquery-3.6.0.min.js"></script>
<script src="{{ asset('/assets/js/jquery.progresstimer.js') }}"></script>
<script src="{{url('/assets/cdn')}}/popper.min.js"></script>
<script src="{{ asset('/assets/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{url('/assets/cdn')}}/toastr.min.js"></script>
<script src="{{url('/assets/cdn')}}/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {

        // $('#example').DataTable();

        $(document).on("click", "#scrollToTop", function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $("header").offset().top
            }, 500);
            $(this).hide();
            $("#scrollToBottom").show();
        });

        $(document).on("click", "#scrollToBottom", function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $("#footer-bar").offset().top
            }, 500);
            $(this).hide();
            $("#scrollToTop").show();
        });


        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();
            if (windowpos >= 50) {
                $("#scrollToTop").fadeIn();
            } else {
                $("#scrollToTop").fadeOut();
            }
        });

    })

</script>
@yield('script')
</body>
</html>
