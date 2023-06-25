@extends('layouts.master')
@section('content')
    @include('layouts.header')
    @include('layouts.newsticker')

        <div class="widgets single-page-content-wrap section-padding" style="padding: 49px 0;">
            <div class="container">
                <div class="row">

                    <!-- page-content -->
                    <div class="col-lg-12 col-md-12 page-content">
{{--                        <h3 class="page-title">{{ $notice->title }}</h3>--}}

                        <div class="notice-description">
                            {!! $notice->description !!}
                        </div>

                        @foreach($notice->files as $file)
                        <div class="entry-content" style="margin-bottom: 30px;">
                            <iframe style="height: 674px;" src="{{asset($file->pdf)}}"></iframe>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>        
        </div>

@endsection