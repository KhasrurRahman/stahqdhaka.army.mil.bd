@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')

<style>
    .os1-summary strong.site-color-1 {
        color: #31a650;
    }

    .os1-summary h3,
    .os1-summary h6,
    .os1-summary strong {
        color: #a23021;
    }
</style>
<div class="single-page-content-wrap section-paddinghjh">
    <div class="container">
        <div class="row">

            <!-- page-content -->
            <div class="col-lg-12 page-content">

                <div class="row officer-section-1 section-padding">
                    <div class="col-lg-5" style="border: 1px solid;">
                        <figure class="os1-fig">
                            <img src="" alt="Image Here">
                        </figure>
                    </div>

                    <div class="col-lg-7">
                        <div class="os1-summary">
                            <h3> About Us</h3>
                          
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection