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
                    <div class="col-lg-9 col-md-8 page-content">
                        <h3 class="page-title">Graveyard</h3>

                        <div class="entry-content">
                            <iframe src="{{asset('assets/images/sthq/pdf/GraveYard.jpg')}}" sandbox="allow-same-origin"></iframe>
                        </div>                     
                    </div>
                </div>
            </div>        
        </div>

@endsection