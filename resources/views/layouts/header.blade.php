<style>
  ul#mujibBorsho li {
    display: inline-block;
  }

  ul#mujibBorsho li span {
    font-size: 100%;
    font-family: arial;
    font-weight: bold;
    padding: 0px;
    line-height: 0px;
    color: #c4161c;
  }

  ul#mujibBorsho li p {
    color: #000000;
    font-size: 78%;
    font-weight: bold;
    padding: 0px;
    font-family: arial;
    padding-top: 10px;
    line-height: 0px;
    color: #c5782a;
  }

  ul#mujibBorsho li.seperator {
    font-size: 100%;
    line-height: 0px;
    vertical-align: top;
    padding: 0px;
    padding-top: 7px;
  }
  div#videoDisplay {
    right: 40px;
    height: 40px;
    transform: rotate(-90deg);
    transform-origin: 100% 0;
    position: fixed;
    line-height: 40px;
    background: red;
    color: #fff;
    z-index: 99999;
    top: 20%;
    padding: 0 2%;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
    width: auto;

  }
  #videoModal .modal-body {
    padding: 0;  /* Remove padding from the modal body */
  }

  #videoModal video {
    width: 100%;  /* Make the video width 100% of the container */
    height: auto; /* Automatically adjust the height */
  }
  div#videoDisplay a {
    color: yellow;
    cursor: pointer;
  }
</style>

<!-- site-header -->
<header class="site-header" style="">

  <!-- header-top -->
  <div class="header-top">
    <div class="container">
      <div class="row">
        <div class="col-6 col-sm-6 htop-left">
          <span class="date">Today: <?php echo date('l, F j, Y'); ?></span>
        </div>
        <div class="col-6 col-sm-6 htop-right text-right">                               
          <ul class="htop-menu">
            {{-- @if(!auth()->guard('applicant')->check())
            <li><a href="{{route('customer.login')}}"><i class="fa fa-user"></i> Login</a></li>
            <li><a href="{{route('customer.register')}}"><i class="fa fa-user-plus"></i> Register</a></li> --}}
            @if(auth()->guard('applicant')->check())
            <li class="nav-item dropdown" style="padding: 0; border-right: 0;">
              <a id="navbarDropdown" style="padding:5px; " class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::guard('applicant')->user()->name }} <span class="caret"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="z-index: 9999999;">
                <a class="dropdown-item" style="color: #000;" href="{{ url('/about/customer') }}">My Account</a>
                <a id="logout" class="dropdown-item" style="color: #000;" href="{{ route('customer.logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
               {{csrf_field()}}
             </form>
           </div>
         </li>
         @endif 
       </ul>
     </div>
   </div>
 </div>
</div>

<!-- main-header -->
<div class="main-header">

  <div class="container">
    <div class="row">
      <div class="col-lg-12 logo-menu">
        <div class="logo">
          @if(auth()->guard('applicant')->check())
          <a href="{{url('/customer/home')}}"><img src="{{asset('assets/images/sthq/logo.png')}}" alt="logo"></a>
          @else
          <a href="{{url('/')}}"><img src="{{asset('assets/images/sthq/logo.png')}}" alt="logo"></a>
          @endif
        </div>
        <div class="contact-info-1">
          <div class="contact-content">
            <span><i class="fa fa-phone"></i> Tel: {{ $header_footer->telephone }}</span><br>
            <span><i class="fa fa-mobile"></i> Mob: {{ $header_footer->mobile }}</span> <br>
            <span><i class="fa fa-fax" aria-hidden="true"></i> FAX : {{ $header_footer->fax }}</span>
          </div>
          <div class="contact-content map-content">
            <span><i class="fa fa-mobile"></i> Sticker Query: {{ $header_footer->sticker_query }}</span>
            <span><i class="fa fa-map-marker"></i> Location: {{ $header_footer->location }}</span>
          </div>
          
{{--          <div class="contact-content map-content" style="margin-left: 170px">--}}
{{--            <img src="{{ asset('assets/images/mujiblogo2.png') }}" style="float: right; right: 0px; left: auto; bottom: auto; top: 30px; position: fixed; z-index: 999999; width: 220px">--}}
{{--          </div>--}}
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- main-header closed-->

<!-- main-menu-section starts -->
<div class="main-menu-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <nav class="main-menu-wrap">
          <button class="navbar-icon">
              <i class="fas fa-bars"></i>
          </button>
          <ul class="main-menu">
            <li>
               @if(auth()->guard('applicant')->check())
                <a href="{{url('/customer/home')}}">Home</a>
               @else
                <a href="{{url('/')}}">Home</a>
               @endif 
            </li>
            <li>
              <a href="#">Sticker</a>
              <ul class="submenu">
                <li><a href="{{url('/policy')}}">Policy</a></li>
                @if(!auth()->guard('applicant')->check())
              
                  <li><a href="{{route('customer.login')}}">Login</a></li>
                  <li><a href="{{route('customer.register')}}">Register</a></li>
                
              
                @endif
              </ul>
            </li>
            <li>
              <a href="#">Graveyard</a>
              <ul class="submenu">
                <li><a href="{{url('/graveyard')}}">Graveyard Allotment</a></li>
                <li><a href="{{asset('assets/images/fixed_files/'.$all_fixed_file->graveyard_policy)}}" target="_blank">Graveyard Policy</a></li>
                <li><a href="{{asset('assets/images/fixed_files/'.$all_fixed_file->graveyard_application)}}" target="_blank">Graveyard Application Form </a></li>
              </ul>
            </li>
            <li>
              <a href="#">Information</a>
              <ul class="submenu">
                <li>
                  <a href="#">Access Control</a>
                  <ul class="submenu">
                    <li><a href="{{url('/bus')}}">Bus</a></li>
                    <li><a href="{{url('/private')}}">Private</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#">Health and Hygiene</a>
                  <ul class="submenu">
                    <li><a href="{{url('/anti-malaria-drive')}}">Anti malaria Drive</a></li>
                    <li><a href="{{url('/drainage-and-cleaning')}}">Drainage and Cleaning</a></li>
                    <li><a href="{{url('/disposal-of-garbage')}}">Disposal of Garbage</a></li>
                  </ul>
                </li>
                <li><a href="{{url('/mp-checkpost')}}">MP Checkpost</a></li>
                <li><a href="{{url('/shuttle-service')}}">Shuttle Service</a></li>
                <li><a href="{{url('/other-services')}}">Other Services</a></li>
                <li><a href="{{url('/contact-info')}}">General Contact Info</a></li>
                <li><a href="{{url('/helpline')}}">Helpline</a></li>
              </ul>
            </li>
            <li><a href="#sta_gallery">Photo Gallery</a></li>
            <li>
              <a href="#" style="text-transform:capitalize;">Tutorial </a>
              <ul class="submenu">
                <li><a href="{{ url('/').'/assets/images/fixed_files/'. $all_fixed_file->sign_up_tutorial }}" target="_blank">Sign Up</a></li>
                <li><a href="{{ url('/').'/assets/images/fixed_files/'.$all_fixed_file->sticker_tutorial }}" target="_blank">Sticker</a></li>
              
              </ul>
            </li>
            <li><a href="#contact-us">Contact</a></li>
            {{--<li><a href="{{asset('assets/pdf/Notice_update.pdf')}}" target="_blank"><img src="{{ url('assets/images/imp_notice_red.gif') }}" alt="Notice" width="120px"></a></li>--}}

            {{-- <li>
              <a href="#" style="text-transform:capitalize;">Apply Now </a>
              @if(!auth()->guard('applicant')->check())
              <ul class="submenu">
                <li><a href="{{route('customer.login')}}">Login</a></li>
                <li><a href="{{route('customer.register')}}">Register</a></li>
              
              </ul>
              @endif
            </li> --}}
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
<!-- main-menu-section ends -->
</header>
<!-- site-header closed -->



