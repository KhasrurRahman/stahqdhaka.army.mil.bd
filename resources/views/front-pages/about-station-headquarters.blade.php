@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
<style>
    
    ul {
        padding-left: 50px;
        margin-bottom: 16px;
        list-style-image: url('{{asset("/assets/images/arrow-1.png")}}');
    }
    ul li {
        list-style: unset;
        /*list-style-type: circle;*/
        margin-bottom: 0px;
        padding-bottom: 3px;
    }
    
</style>
<div class="welcome-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 welcome">
                <h3 style="text-align: center;text-decoration: underline;">
                    Station Headquarters, Dhaka
                </h3>
                {!! $present_commander->description !!}
            </div>
        </div>
    </div>
</div>
@endsection