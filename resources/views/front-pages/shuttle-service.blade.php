@extends('layouts.master')
@section('content')
    @include('layouts.header')
    @include('layouts.newsticker')

        <div class="widgets single-page-content-wrap section-padding">
            <div class="container">
                <div class="row">

                    <!-- sidebar -->
                    @include('layouts.sidebar')

                    <!-- page-content -->
                    <div class="col-md-9 page-content">
                        <h3 class="page-title">Shuttle Service</h3>

                        <div class="entry-content">
                            <img src="{{asset('/assets/images/sthq/pdf/Shuttle-Service_new.jpg') }}" style="width: 100%;">
                        </div>                     
                    </div>
                </div>
            </div>        
        </div>

@endsection