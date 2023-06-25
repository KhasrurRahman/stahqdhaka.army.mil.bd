@extends('layouts.master')
@section('content')
    @include('layouts.header')
    @include('layouts.newsticker')

<style>
.os1-summary strong.site-color-1 {
    color: #31a650;
}

.os1-summary h3, .os1-summary h6, .os1-summary strong {
    color: #a23021;
}
</style>
        <div class="single-page-content-wrap section-paddinghjh">
            <div class="container">
                <div class="row">

                    <!-- page-content -->
                    <div class="col-lg-12 page-content">

                        <div class="row officer-section-1 section-padding">
                            <div class="col-lg-5">
                                <figure class="os1-fig">
                                    <img src="{{ asset('assets/images/majors/'.$major->image) }}" alt="{{ $major->name }}">   
                                </figure>
                            </div>

                            <div class="col-lg-7">
                                <div class="os1-summary">
                                    <h3> {{ $major->name }}</h3>

                                    <p><strong class="site-color-1"> {{ $major->rank }}</strong></p>

                                    <p>
                                        Mob: {{ $major->mobile }}, Tel: {{ $major->telephone }} 
                                    </p>

                                    <h6>Major Responsibility:</h6>


                                    {!! $major->responsibility !!}

                                </div>
                            </div>
                        </div>
                                           
                    </div>
                </div>
            </div>        
        </div>

@endsection