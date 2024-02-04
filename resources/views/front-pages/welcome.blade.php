@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
@include('layouts.slider')

<style>
    .vid-thumb img {
        height: 320px;
        object-fit: cover;
    }

    .vid-thumb {
        cursor: pointer;
    }

    .vid-thumb h1 {
        background: #fff;
        margin-top: -17px;
        font-size: 16px;
        padding: 14px 10px;
    }

    .vid-thumb i {
        position: absolute;
        z-index: 9;
        margin-top: 24%;
        font-size: 86px;
        opacity: 0.5;
        transform: translateX(-50%);
    }

    .ssl_gallery {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px;
    }
    .welcome-video .pcommander p, .welcome-video .pcommander h3 {
    padding-left: 20px;
    text-align: left;
}
</style>

<div class="welcome-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 welcome">
                <h3>
                    Welcome to Station Headquarters<br>
                    Dhaka Cantonment
                </h3>
                <p>{!! substr($present_commander->description, 0, 585) !!}...<a href="{{ url('/') }}/about-station-headquarters">Read More</a></p>
            </div>
            <div class="col-md-6 welcome-video">
                <div class="pcommander">
                    <img src="{{asset('assets/images/commander/'.$present_commander->image)}}" alt="Present Commander" style="width: 265; height:320px;">
                    <h3> {{ $present_commander->title }} </h3>
                    <p><b>BA:</b> {{ $present_commander->ba }} </p>
                    <p><b>Rank:</b> {{ $present_commander->rank }} </p>
                    <p><b>Name:</b> {{ $present_commander->name }} </p>
                    
                    {{-- <p><b>Tel:</b> {{ $present_commander->telephone }}</p> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="team-section-2 section-padding">
    <div class="container">
        <div class="row team-members">
            @foreach ($majors as $major)
            <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/majors/'.$major->image)}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>{{$major->sso}} ({{$major->rank}})</h4>
                        {{-- <p>Mob: {{ $major->mobile }}, Tel: {{ $major->telephone }} </p> --}}
                        <p>
                            BA: {{ $major->ba }}<br>
                            Rank: {{ $major->rank }}<br>
                            Name: {{ $major->name }}<br> 
                        </p>
                        <p><b>Major Responsibility</b><br>
                            {{ $major->short_description }}
                        </p>
                        <p>
                            <a href="{{ route('major', [$major->id,$major->rank]) }}" class="readmore"> More</a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<div class="howitworks-section section-padding d-none">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="howitworks">
                    <h3>HOW IT WAS</h3>
                    <p style="text-transform: uppercase;">WORKING WITH THE EX-SERVICE COMMUNITY IS AN <br>IMPORTANT PART OUR WORK IN THE ORGANIZATION.</p>
                    <p>Our military organizaion was established specifically to help veterans and their families. We welcome those who can offer their ideas, thoughts, and service in achievement of our objectives.</p>
                    <p><a href="#" class="readmore">More</a></p>
                </div>
            </div>

            <!-- Commented for VAPT issues -->
            {{--
            <div class="col-md-6">
                <div class="howitworks-vid">
                   <!--16:9 aspect ratio -->
                   <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/4ADw9I7WbNw" sandbox="allow-same-origin allow-scripts allow-presentation"></iframe>
                </div>
                <!--<img src="{{asset('assets/images/sthq/video-img.png')}}" alt="">-->
        </div>
        --}}
    </div>
</div>
</div>
</div>


<div class="message-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="message">
                    {{ $slogan->text1??'' }}<br>
                    <span> {{ $slogan->text2??'' }} </span>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="widgets section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="widget left-widget">
                    <h3 class="widget-title"><i class="fa fa-bell"></i> Notice</h3>
                    <ul class="widget-menu">
                        @foreach ($pdf_files as $pdf_file)
                        @if ($pdf_file->type == 'notice')
                        <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                        @endif
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget left-widget">
                    <h3 class="widget-title"><i class="fa fa-newspaper"></i> News & Events</h3>
                    <ul class="widget-menu">
                        @foreach ($pdf_files as $pdf_file)
                        @if ($pdf_file->type == 'news_events')
                        <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                        @endif
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget left-widget">
                    <h3 class="widget-title"><i class="fa fa-gavel"></i> Policy</h3>
                    <ul class="widget-menu">
                        @foreach ($pdf_files as $pdf_file)
                        @if ($pdf_file->type == 'policy')
                        <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                        @endif
                        @endforeach
                        {{-- <li><a href="{{url('/policy')}}"><i class="fa fa-external-link-alt"></i> Sticker Policy</a></li> --}}
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget left-widget">
                    <h3 class="widget-title"><i class="fa fa-pen-square"></i> Forms</h3>

                    <ul class="widget-menu">
                        @foreach ($pdf_files as $pdf_file)
                        @if ($pdf_file->type == 'forms')
                        <li><a href="{{asset('assets/pdf_files/'.$pdf_file->file)}}" target="_blank"><i class="fa fa-external-link-alt"></i> {{ $pdf_file->name  }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="sta_gallery" class="section-padding" style="background-image: url('/videos/video-bj.jpg');background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 sta_gallery-wrap text-center">
                <h2 class="section-title">DOHS Executive Committee Election 2023 </h2>

                <div class="row">

                    <div class="col-sm-12 sta_gallery owl-carousel owl-theme gallery_carousel">

                        <div class="gall-img vid-thumb" data-fancybox="gallery" data-caption="ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩" href="{{url('/videos/DOHS-VOTING.mp4')}}">
                            <i class="fa fa-play-circle"></i>
                            <img src="{{url('/videos/DOHS-VOTING.jpg')}}" alt="" />
                            <h1>ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩</h1>
                        </div>
                        <div class="gall-img vid-thumb" data-fancybox="gallery" data-caption="বারিধারা ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩" href="{{url('/videos/DOHS-VOTING-2.mp4')}}">
                            <i class="fa fa-play-circle"></i>
                            <img src="{{url('/videos/DOHS-VOTING-2.jpg')}}" alt="" />
                            <h1>বারিধারা ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩</h1>
                        </div>
                        <div class="gall-img vid-thumb" data-fancybox="gallery" data-caption="মহাখালী ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩" href="{{url('/videos/Mohakhali-DOHS.mp4')}}">
                            <i class="fa fa-play-circle"></i>
                            <img src="{{url('/videos/Mohakhali-DOHS.jpg')}}" alt="" />
                            <h1>মহাখালী ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩</h1>
                        </div>
                        <div class="gall-img vid-thumb" data-fancybox="gallery" data-caption="বনানী ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩" href="{{url('/videos/Bonani-DOHS.mp4')}}">
                            <i class="fa fa-play-circle"></i>
                            <img src="{{url('/videos/Bonani-DOHS.jpg')}}" alt="" />
                            <h1>বনানী ডিওএইচএস পিরিষদ কার্যনির্বাহী কমিটি নির্বাচন -২০২৩</h1>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<div id="sta_gallery" class="gallery-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 sta_gallery-wrap text-center">
                <h2 class="section-title">Photo Gallery</h2>

                <div class="row">

                    <div class="col-sm-12 sta_gallery owl-carousel owl-theme gallery_carousel">
                        @foreach ($photo_galleries as $photo_gallery)
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo_galleries/'.$photo_gallery->image)}}" alt="{{ $photo_gallery->name }}">
                        </div>
                        @endforeach
                    </div>



                </div>

                <!--  <div class="loadmore-wrap text-center">
                    <a href="#" class="loadmore">Getting more</a>
                </div> -->
            </div>
        </div>

    </div>
</div>
<!-- SSL Gallery section Start here -->
<div class="ssl_gallery">
    <div>
        <img src="{{ asset('assets/ssl-banner-images/SSLCOMMERZ Pay With logo All Size_Aug 21-03-Feb-13-2022-05-30-15-78-AM.png') }}" alt="">
    </div>


</div>
<!-- SSL Gallery section End here -->

<!-- Commented for VAPT issues -->
{{--
        <div class="location-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5163.038133664099!2d90.38885460736066!3d23.78944906268389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c73effb31dc7%3A0x65ff33f01fc6f8b4!2sStation+Headquarters+Canteen!5e0!3m2!1sen!2sbd!4v1537252406842" width="100%" height="480" frameborder="0" style="border:0" allowfullscreen sandbox="allow-same-origin allow-scripts"></iframe>
        </div>
        --}}

<div class="contact-section section-padding" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 contact">
                <h2 class="section-title text-center">Contact Us</h2>

                <div class="contact-form">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <!-- <label for="inputName">Name:</label> -->
                                <input type="text" class="form-control" id="inputName" placeholder="Name">
                            </div>

                            <div class="form-group col-md-6">
                                <!-- <label for="inputEmail4">Email:</label> -->
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- <label for="inputSubject">Subject:</label> -->
                            <input type="text" class="form-control" id="inputSubject" autocomplete="off" placeholder="Subject">
                        </div>

                        <div class="form-group">
                            <!-- <label for="textareaMessage">Message:</label> -->
                            <textarea name="textareaMessage" class="form-control" id="textareaMessage" style="width: 100%;" placeholder="Message"></textarea>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-contact-send">Send</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection