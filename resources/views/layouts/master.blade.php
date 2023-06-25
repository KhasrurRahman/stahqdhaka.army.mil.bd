<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Station Headquarters, Dhaka Cantonment, Dhaka </title>
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/all.css" >
    <link rel="stylesheet" href="{{asset('/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/front-style.css')}}?id=23">
    <link rel="shortcut icon" href="{{asset('assets/images/LogoS1.png')}}" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/assets/cdn')}}/animate.min.css">

    <link rel="stylesheet" href="{{url('/assets/cdn')}}/animate.min.css">

    <script src="{{url('/assets/cdn')}}/jquery-3.6.0.min.js"></script>
    <script src="{{url('/assets/js/jquery.fancybox.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('/assets/css/jquery.fancybox.min.css')}}">



    <style>
        ul.widget-menu {
            overflow-x: auto;
            height: 280px;
            list-style: none;
            padding: 10px 0;
            margin-bottom: 0;
        }
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
        /*span.mrq-text {*/
        /*    text-shadow: 1px 4px 2px black;*/
        /*}*/

        /*.elementToFadeInAndOut {*/
        /*    color: #fff;*/
        /*    -webkit-animation: fadeinoutkhan 1s linear infinite;*/
        /*    animation: fadeinoutkhan 3s linear infinite;*/
        /*}*/

        /*@-webkit-keyframes fadeinoutkhan {*/
        /*    0%,100% {*/
        /*        opacity: 0.9;*/
        /*        color: #fff;*/
        /*    }*/
        /*    50% {*/
        /*        opacity: 1;*/
        /*        color: #A22F18;*/
        /*    }*/
        /*}*/

        /*@keyframes fadeinoutkhan {*/
        /*    0%,100% {*/
        /*        opacity: 0.9;*/
        /*        color: #fff;*/
        /*    }*/
        /*    50% {*/
        /*        opacity: 1;*/
        /*        color: #A22F18;*/
        /*    }*/
        /*}*/

        /*first animation start*/
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
{{--
<div id="videoDisplay"><a data-toggle="modal" data-target="#videoModal"><i class="fas fa-video"></i>  DOHS Executive Committee Election 2023</a></div>
--}}
<!-- Modal structure -->
<div class="modal" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <video id="videoPlayer" controls>
                    <source src="/videos/DOHS-VOTING.mp4" type="video/mp4">
                    <!-- Add additional video sources if needed -->
                </video>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <div class="site-wrapper">
        @yield('content')

        @include('layouts.footer')
    </div>

    
    <script src="{{url('/assets/cdn')}}/popper.min.js"></script>
    <script src="{{url('/assets/js')}}/owl.carousel.min.js"></script>
    <script src="{{url('/assets/cdn')}}/bootstrap.min.js"></script>

    <script src="{{url('/assets/cdn')}}/masonry.pkgd.min.js"></script>
    <script src="{{url('/assets/cdn')}}/jquery.bxslider.min.js"></script>


    <script>
        $(document).ready(function(){
            $('.main-slider').bxSlider({
                mode: 'fade',
                captions: true,
                pause: 5000,
                auto: true,
            });

            var gallery_carousel = $('.gallery_carousel');
            
            // gallery_carousel
            gallery_carousel.owlCarousel({
                margin: 15,
                loop:true,
                dots: true,
                nav:true,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsiveClass:true,
                navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
                ],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1200:{
                        items:2
                    }
                }
            });        
            // setTimeout(function(){
            //     $('.sta_gallery').masonry({
            //       // options
            //       itemSelector: '.gall-img',
            //       columnWidth: 550,
            //       gutter: 10
            //     });
            // }, 1000);

            // scrollTop
            $(".navbar-icon").on('click', function(){       
                $('.main-menu').stop(true, false, true).slideToggle(300);
            });
            // Submenu SlideToggle
            $('ul.submenu').parent('li').addClass('has-submenu').children("a").append('<i class="fa fa-angle-down"></i>');
            
            if ($(window).width() > 767) {
                $("ul.main-menu li").hover(function() {
                    $(this).children('ul.submenu').stop(true, false, true).slideToggle(300);
                });
            }
            else {
                $('ul.main-menu>li>a>i').click(function(e) {               
                    $(this).parent("ul.main-menu li a").parent("ul.main-menu li").children('ul.submenu').stop(true, false, true).slideToggle(300); // toggle element
                    return false;
                });
            }


            // click event to scroll to next section
            $('ul.main-menu>li>a').on('click', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: $($anchor.attr('href')).offset().top
                }, 2000);
            });

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

            $(".role").change(function() {
                $(".role").prop('checked', false);
                $(this).prop('checked', true);
                $("#submit").attr('disabled', false);
            });   
            $(".team-member a.readmore").click( function(event) {
                // event.preventDefault();
                console.log('hello click');
            }); 
             
var currentyear = new Date().getFullYear()+ 1;
$('.sticker_next_year').text(currentyear);
    });

        $(document).ready(function() {
            // Initialize the modal
            $('#videoModal').modal({
                show: false  // Ensures the modal is hidden by default
            });

            // Pause video when modal is closed
            $('#videoModal').on('hidden.bs.modal', function() {
                $('#videoPlayer').get(0).pause();
            });

            // Play video when modal is opened
            $('#videoModal').on('shown.bs.modal', function() {
                $('#videoPlayer').get(0).play();
            });
        });
    </script>

    @yield('script-container')
</body>
</html>

