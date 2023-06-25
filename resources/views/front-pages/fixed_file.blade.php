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
                        <h3 class="page-title"> {{ $title }} </h3>

                        <div class="entry-content">
                            @if (!empty($fixed_file))
                                <iframe src="{{asset('assets/images/fixed_files/'.$fixed_file)}}"></iframe>
                            @else 
                                <div style="text-align: center;font-size: 30px;color: red;">
                                   There are no file for view. !!!
                                </div>    
                            @endif
                            
                        </div>                     
                    </div>
                </div>
            </div>        
        </div>

@endsection
