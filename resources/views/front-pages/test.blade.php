@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
@include('layouts.slider')
<div class="welcome-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6 welcome">
                <h3>
                    Welcome to Station Headquarters<br>
                    Dhaka Cantonment
                </h3>
                <p>Station Headquarters Dhaka is one of the oldest establishments of Bangladesh Army. This pioneer life line establishment came into existence in the year 1948. After the glorious victory in the great War of Liberation of Bangladesh in 1971, this pivotal establishment started functioning on 31 December 1971 under the able and visionary leadership of Col S M Reza as first officiating Station Commander. </p>
                <p>Station Headquarters, Dhaka is basically a service providing organization. The services it provides for the serving and retired Defence officers as well as the civilians are...<a href="http://stahqdhaka.org.bd/about-station-headquarters/">Read More >></a></p>
            </div>
            <div class="col-md-6 welcome-video"> 
                <div class="pcommander text-center">
                    <img src="{{asset('assets/images/sthq/833984545_comdt stahq dhaka.jpg')}}" alt="">
                    <h3>Present Commander</h3>
                    <p><b>Rank:</b> Brig Gen </p>
                    <p><b>Name:</b> A S M Anisul Haque, SGP,BGBM,psc </p>
                    <p><b>BA:</b> 4234 </p>
                    <p><b>Tel:</b> 3610 (Office) 8753610 (Office)</p>
                </div>                      
            </div>
        </div>
    </div>
</div>
<div class="team-section-2 section-padding">
    <div class="container">
        <div class="row team-members">
            <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/sso-1.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, Kazi  Mozammel Hossain, SSO-1</h4>
                        <p>Mob: 01769013612, Tel: 3612 </p>
                        <p><b>Major Responsibility</b><br>
                        All admin of sta HQ, JCO's/OR, sy and gds, accn for JCO's/OR, emp of civil staff, unit docus incl sheet roll etc, stores...</p>
                        <p><a href="{{url('/major-maj-kazi-mozammel-hossain-sso-1')}}" class="readmore">More</a></p>
                    </div>                        
                </div>
            </div>
            <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/sso-2.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, MD Amjad Hossain, SSO-2</h4>
                        <p>Mob: 01769013614, Tel: 3614</p>
                        <p><b>Major Responsibility</b> <br>
                        Allotment of JCO's/ OR/ Followers married and outliving permission, JCO's/ OR/ followers accn and market, all exams, admin of the CWC, doctor...</p>
                        <p><a href="{{url('/major-md-amjad-hossain-sso-2')}}" class="readmore">More</a></p>
                    </div>                      
                </div>
            </div>
            
            <!-- <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/1761320770_Maj-Iftekhar-Ahmed-Quraishi-SSO-2.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, Maj Iftekhar Ahmed Quraishi, SSO-2</h4>
                        <p>Mob: 01769013614, Tel: 3614</p>
                        <p><b>Major Responsibility</b> <br>
                        Allotment of JCO's/ OR/ Followers married and outliving permission, JCO's/ OR/ followers accn and market, all exams, admin of the CWC, doctor...</p>
                        <p><a href="#" class="readmore">More</a></p>
                    </div>                      
                </div>
            </div> -->

            <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/sso-3.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, Md. Shahed Meher, SSO-3</h4>
                        <p>Mob: 01769013616, Tel: 3616</p>
                        <p><b>Major Responsibility</b><br>
                        Reveille & retreat, PT/games, office timing/dress for winter/ summer to all concerned, offrs mess, stoke taking/Svy of mess handing/ taking/ audit board, admin of mosque...</p>
                        <p><a href="{{url('/major-maj-md-shahed-meher-sso-3')}}" class="readmore">More</a></p>
                    </div>                      
                </div>
            </div>
            <div class="col-md-6 team-member">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/sso-4.JPG')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, Abu Russell, SSO-4</h4>
                        <p>Mob: 01769013618, Tel: 3618</p>
                        <p><b>Major Responsibility</b> <br>
                        Land admin, area, bldgs, official bk alloc, issuing of rly warrant/MC note, movOdetention cert, coord/ maint/ supervision etc...</p>
                        <p><a href="{{url('/major-maj-abu-russell-sso-4')}}" class="readmore">More</a></p>
                    </div>                     
                </div>
            </div>

            <!-- <div class="col-md-6 team-member">
               <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/-117760156_STO.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, SM Habib Ibne Jahan, STO</h4>
                        <p>Mob: 01769013620, Tel: 3620 </p>
                        <p><b>Major Responsibility</b><br>
                       Sticker, Public Vehicle, Station Order and Military Vehicle Indent, School bus, temp pass, issuing of Tpt, Issuing bus card, Shuttle svc, MES Function, CSD...</p>
                        <p><a href="#" class="readmore">More</a></p>
                   </div>                   
               </div> 
            </div>   -->

            <div class="col-md-6 team-member">
                <div class="row"> 
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/sthq/sticker-officer.jpg')}}" alt="">
                    </div>
                    <div class="col-md-8">
                        <h4>Major, Md. Nazmul Haque, STO</h4>
                        <p>Mob: 01769013620, Tel: 3620 </p>
                        <p><b>Major Responsibility</b><br>
                        Sticker, Public Vehicle, Station Order and Military Vehicle Indent, School bus, temp pass, issuing of Tpt, Issuing bus card, Shuttle svc, MES Function, CSD...</p> 
                        <p><a href="{{ url('/major-md-nazmul-haque-sto' ) }}" class="readmore">More</a></p>
                    </div>                    
                </div>  
            </div>  
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
            <div class="col-md-6">
                <div class="howitworks-vid">
                    

                <!--<img src="{{asset('assets/images/sthq/video-img.png')}}" alt="">-->
            </div>
        </div>
    </div>
</div>
</div>


<div class="message-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="message">
                    Protect Your Motherland,<br>
                    <span>Your Family, Your Beliefs.</span>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="widgets section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">                           
                <div class="widget left-widget notice-widget">                                                   
                    <h3 class="widget-title"><i class="fa fa-bell"></i> Notice</h3>
                    <div class="notice-content">
                        <img src="{{asset('assets/pdf/Sticker-Notice.jpg')}}"/>
                    </div>
                    
                </div>
            </div>

            <div class="col-lg-3 col-md-6">    
                <div class="widget left-widget">                                                   
                    <h3 class="widget-title"><i class="fa fa-newspaper"></i> News & Events</h3>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">                        
                <div class="widget left-widget">                                                   
                    <h3 class="widget-title"><i class="fa fa-gavel"></i> Policy</h3>
                    <ul class="widget-menu">
                        <li><a href="{{url('/policy')}}"><i class="fa fa-external-link-alt"></i> Sticker Policy</a></li>
                        <li><a href="{{asset('assets/pdf/graviyard-policy.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Graveyard Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">                          
                <div class="widget left-widget">                                                  
                    <h3 class="widget-title"><i class="fa fa-pen-square"></i> Forms</h3>

                    <ul class="widget-menu">
                        <li><a href="{{asset('assets/pdf/-2033193580-SchoolCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> School Certificate Form</a></li>
                        <li><a href="{{asset('assets/pdf/1727069855-JobCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Job Certificate</a></li>
                        <li><a href="{{asset('assets/pdf/240823335-HouseOwnerCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> House Owner/CEO Certificate</a></li>
                        <li><a href="{{asset('assets/pdf/531393775-WardCommCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Ward Commissioner Certificate</a></li>
                        <li><a href="{{asset('assets/pdf/-902561939-ApplicationForm_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Graveyard Application Form</a></li>
                        <li><a href="{{asset('assets/pdf/1846078746-FreedomFighterCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Freedom Fighter Certificate (Sample)</a></li>
                        <li><a href="{{asset('assets/pdf/-452755646-DeathCertificate_1.pdf')}}" target="_blank"><i class="fa fa-external-link-alt"></i> Death Certificate (Sample)</a></li>
                    </ul>
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
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/1.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/2.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/3.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/4.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/5.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/6.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/7.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/8.jpg')}}" alt="">
                        </div>
                        
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/9.jpg')}}" alt="">
                        </div>
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/10.png')}}" alt="">
                        </div>
                        <div class="gall-img">
                            <img src="{{asset('assets/images/photo-gallery/11.png')}}" alt="">
                        </div>  
                    </div>

                        
                          
                </div>

                       <!--  <div class="loadmore-wrap text-center">
                            <a href="#" class="loadmore">Getting more</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>




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
                                    <textarea name="textareaMessage"  class="form-control" id="textareaMessage" style="width: 100%;" placeholder="Message"></textarea>
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