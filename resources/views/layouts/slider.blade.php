
            <div class="main-slider">
                {{-- <div class="single-slide-wrap slide-1">
                    <div class="slider-overlay"></div>
                    <img src="{{asset('assets/images/sthq/station-headquaters-slider-images-1.jpg')}}" alt="">
                    
                    <div class="single-slide">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slide-text text-center">
                                        <h3>
                                            For sticker query <br>  
                                            Please contact here <span class="phone">01797585010</span><br>
                                            Sticker application/renewal subscription <br>
                                            <span class="open2018">open for year 2018</span>
                                        </h3>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div> --}}
                @foreach ($front_sliders as $slider)
                    <div class="single-slide-wrap slide-2">
                        <div class="slider-overlay"></div>
                        <img src="{{asset('assets/images/sliders/'.$slider->image)}}" alt="{{ $slider->name }}" style="width:100%; max-height:414px;">
                    </div>
                @endforeach
            </div>